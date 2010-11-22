<?php

/**
 * database actions.
 *
 * @package    freerms
 * @subpackage database
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class databaseActions extends sfActions
{
  public function preExecute()
  {
    layoutActions::chooseLayout( $this );
  }

  public function executeIndex(sfWebRequest $request)
  {
    $user_affiliation = $this->getUser()->getLibraryIds();
    $subject = $request->getParameter('subject');    
               
    $c = new Criteria();
    $c->setDistinct();
    $c->add(EResourcePeer::SUPPRESSION, 0);
    $c->add(LibraryPeer::ID, $user_affiliation, Criteria::IN);
    $c->addJoin(LibraryPeer::ID, AcqLibAssocPeer::LIB_ID);
    $c->addJoin(AcqLibAssocPeer::ACQ_ID, AcquisitionPeer::ID);
    $c->addJoin(AcquisitionPeer::ID, EResourcePeer::ACQ_ID);

    if ($subject){
      $this->selected_subject = $subject;

      $c->add(DbSubjectPeer::SLUG, $subject);
      $c->addJoin(EResourcePeer::ID, EResourceDbSubjectAssocPeer::ER_ID);
      $c->addJoin(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, DbSubjectPeer::ID);
    }
    else {
      $this->selected_subject = null;
    }

    $c->addAscendingOrderByColumn(EResourcePeer::SORT_TITLE);       

    $this->databases = EResourcePeer::doSelect($c);

    $c = new Criteria();
    $c->addAscendingOrderByColumn(DbSubjectPeer::LABEL);

    $this->db_subject_list = DbSubjectPeer::doSelect($c);
  }

  public function executeAccess(sfWebRequest $request)
  {
    $er_id = $request->getParameter('id')
      or $alt_id = $request->getParameter('alt_id');
    
    $this->forward404Unless($er_id || $alt_id);
    
    $c = new Criteria();
    $c->add( EResourcePeer::DELETED_AT, null, Criteria::ISNULL );

    $er_id
      ? $c->add(EResourcePeer::ID, $er_id)
      : $c->add(EResourcePeer::ALT_ID, $alt_id, Criteria::LIKE);

    $ers = EResourcePeer::doSelectJoinAccessInfo($c);
    $this->forward404Unless($ers);
    $this->er = $ers[0];
    $er_id = $this->er->getId();
    
    $access = $this->er->getAccessInfo();
    
    $user_affiliation = $this->getUser()->getLibraryIds();
    
    if (!$access) {
      $this->er->recordUsageAttempt($user_affiliation[0], false,
        'no access information');
      $this->forward404();
    }
    
    // if not available to this user
    if (! array_intersect($user_affiliation, $this->er->getLibraryIds()) ) {
      $this->er->recordUsageAttempt($user_affiliation[0], false,
        'not available to user');
      $this->setTemplate('unauthorized');
      return;
    }
    
    // figure out which referral method to use
    if ($this->getUser()->getOnsiteLibraryId()) {
      $access_uri = $access->getOnsiteAccessUri();
      $auth_id = $access->getOnsiteAuthMethodId();
    } else {
      $access_uri = $access->getOffsiteAccessUri();
      $auth_id = $access->getOffsiteAuthMethodId();
    }
    

    if ($this->er->getProductUnavailable()) {
      $this->er->recordUsageAttempt($user_affiliation[0], false, 'unavailable');
      $this->setTemplate('unavailable');

      return;
    }
    $auth = AuthMethodPeer::retrieveByPK($auth_id);

    // cleared to refer
    
    $this->er->recordUsageAttempt($user_affiliation[0], true);
    
    switch ($auth->getLabel())
    {
      case 'Script':
      case 'IP + Script':
        $root = str_replace('\\', '/', sfConfig::get('sf_root_dir'));
        $script_path = "$root/lib/access/eresource$er_id.inc.php";
        $this->forward404Unless(is_readable($script_path));
        require($script_path);
        return;
        break;
      
      case 'Referer URL':
        $this->getUser()->setFlash('er_id', $er_id);
        $this->getUser()->setFlash('access_uri', $access_uri);
        $this->redirect('database/refer');
        break;
      
      case 'EZproxy':
        $library = LibraryPeer::retrieveByPK($user_affiliation[0]);
        $proxy_uri = freermsEZproxy::getEZproxyTicketUrl(
          $library, $access_uri, $this->getUser()->getAttribute('username')
        );
        $this->redirect($proxy_uri);
        break;

      case 'ebrarySSO':
        $library = LibraryPeer::retrieveByPK($user_affiliation[0]);

        $ebrary_uri = 'http://' . $library->getEZProxyHost()
                    . '/ebrary/touro/unauthorized';

        $proxy_uri = freermsEZproxy::getEZproxyTicketUrl(
          $library, $ebrary_uri, $this->getUser()->getUsername()
        );

        $this->redirect($proxy_uri);
        break;
        
      case 'Unavailable':
        $this->getUser()->setFlash('title', $er->getTitle());        
        $this->redirect('database/authmethodUnavailable');
        break;
      
      default:
        $this->redirect($access_uri);
        break;
    }
  }

  public function executeRefer()
  {
    // FIXME: sample template is now broken
    $er_id = $this->getUser()->getFlash('er_id');
    $this->access_uri = $this->getUser()->getFlash('access_uri');

    if (!$this->access_uri) {
      $this->redirect(sfConfig::get('app_homepage-redirect-url'));
    }

    if ($er_id) {
      $this->er = EResourcePeer::retrieveByPK($er_id);
      $this->forward404Unless($this->er);
    }
  }

  public function executeURLRefer(sfWebRequest $request)
  {
    $raw_url = $request->getUri();
    $url = substr($raw_url, strpos($raw_url, '/direct-refer/')+14);
    
    $this->getUser()->setFlash('er_id', null);
    $this->getUser()->setFlash('access_uri', $url);
    $this->redirect('database/refer');
  }
  
  public function executeHandleUnauthorized()
  {
    $this->title = $this->getUser()->getFlash('title');
  }
  
  public function executeAuthmethodUnavailable(sfWebRequest $request)
  {
    $this->title = $this->getUser()->getFlash('title');
  }

  public function executeDirectUrl(sfWebRequest $request)
  {
    $raw_url = $request->getUri();
    $url     = substr($raw_url, strrpos($raw_url, '/url/')+5);
    // commented out to fix RT #1266
    // $url = urldecode( $url );

    // FIXME: remove host dependency
    if ( strpos( $url, 'erms.tourolib.org' ) ) {
      $this->redirect( $url );
    }

    $user_affiliation = $this->getUser()->getLibraryIds();
    $user_libraries = LibraryPeer::retrieveByPKs($user_affiliation);
    $this->forward404Unless($user_libraries);


    // FIXME: remove once we have our ebrary MARC records fixed
    if (strpos( $url, 'ebrary' ) !== false) {
      $this->redirect( $url );
    }

    if ($this->getUser()->getOnsiteLibraryId()) {
      $this->redirect( $url );
    }

    $proxy_url = freermsEZproxy::getEZproxyTicketUrl(
      $user_libraries[0], $url, $this->getUser()->getAttribute('username')
    );
    $this->redirect($proxy_url);
  }

  public function executeDirectRefer(sfWebRequest $request)
  {
    $raw_url = $request->getUri();
    $url = substr($raw_url, strpos($raw_url, '-refer/')+7);
    
    $er_id = $this->getUser()->getFlash('er_id');
    $this->access_uri = $this->getUser()->getFlash('access_uri');

    if (!$er_id || !$this->access_uri) {
      $this->redirect(sfConfig::get('app_homepage-redirect-url'));
    }
    $this->er = EResourcePeer::retrieveByPK($er_id);
    $this->forward404Unless($this->er);
  }
}
