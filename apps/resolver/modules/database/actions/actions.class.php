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
    $subject_slug = $request->getParameter('subject');

    $subject = DbSubjectPeer::retrieveBySlug( $subject_slug );
               
    $c = new Criteria();
    $c->setDistinct();
    $c->add(EResourcePeer::SUPPRESSION, 0);

    if ($subject) {
      $this->selected_subject = $subject_slug;

      $this->getUser()->setAttribute('subject', $subject_slug);

      $c->addJoin(EResourcePeer::ID, EResourceDbSubjectAssocPeer::ER_ID);
      $c->add(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, $subject->getId());

      $c1 = clone $c;
      $c1->add(EResourceDbSubjectAssocPeer::FEATURED_WEIGHT, -1, Criteria::NOT_EQUAL);
      $c1->addAscendingOrderByColumn(EresourceDbSubjectAssocPeer::FEATURED_WEIGHT);

      $this->featured_dbs = EResourcePeer::doSelect($c1);
    }
    else {
      $this->selected_subject = null;
      $this->featured_dbs = array();
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
    
    if ($this->er->getProductUnavailable()) {
      $this->er->recordUsageAttempt($user_affiliation[0], false, 'unavailable');
      $this->setTemplate('unavailable');

      return;
    }

    // cleared to refer
    
    $this->er->recordUsageAttempt($user_affiliation[0], true);

    $access_handler = BaseAccessHandler::factory( $this );

    if ( ! $access_handler ) {
      throw new UnexpectedValueException( 'No access handler generated' );
    }

    return $access_handler->execute();
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
  
  public function executeUnavailableHandler(sfWebRequest $request)
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

  public function getEResource()
  {
    if ( $this->er instanceof EResource ) {
      return $this->er;
    }
    else {
      return null;
    }
  }
}
