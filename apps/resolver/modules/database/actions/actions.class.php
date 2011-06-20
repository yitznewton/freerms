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
  /**
   * @var EResource
   */
  public $er;
  
  public function executeIndex(sfWebRequest $request)
  {
    $subject_slug  = $request->getParameter('subject');
    $this->subject = DbSubjectPeer::retrieveBySlug( $subject_slug );
    $affiliation   = $this->getContext()->getAffiliation();
    
    $show_featured = LibraryPeer::isAnyShowFeaturedSubjects(
      $affiliation->get() );
    
    if ( $this->subject && $show_featured ) {
      $this->featured_dbs = EResourcePeer::retrieveByAffiliationAndSubject(
        $affiliation->get(), $this->subject, true );
    }
    else {
      $this->featured_dbs = array();
    }
    
    $this->subject_default = $subject_slug;
    
    $c_subject_widget = new Criteria();
    $c_subject_widget->addJoin( DbSubjectPeer::ID, EResourceDbSubjectAssocPeer::DB_SUBJECT_ID );
    $c_subject_widget->addJoin( EResourceDbSubjectAssocPeer::ER_ID, EResourcePeer::ID );
    $c_subject_widget->add( EResourcePeer::DELETED_AT, null, Criteria::ISNULL );
    $c_subject_widget->add( EResourcePeer::SUPPRESSION, 0 );
    $c_subject_widget->addAscendingOrderByColumn( DbSubjectPeer::LABEL );
    
    $this->subject_widget = new sfWidgetFormPropelChoice( array(
      'add_empty'  => true,
      'model'      => 'DbSubject',
      'criteria'   => $c_subject_widget,
      'key_method' => 'getSlug',
    ));

    $this->databases = EResourcePeer::retrieveByAffiliationAndSubject(
      $affiliation->get(), $this->subject );
  }

  public function executeAccess(sfWebRequest $request)
  {
    $er_id = $request->getParameter('id')
      or $alt_id = $request->getParameter('alt_id');
    
    $this->forward404Unless( $er_id || $alt_id );
    
    $c = new Criteria();

    if ( $er_id ) {
      $c->add(EResourcePeer::ID, $er_id);
    }
    else {
      $c->add(EResourcePeer::ALT_ID, $alt_id, Criteria::LIKE);
    }

    $ers = EResourcePeer::doSelectJoinAccessInfo($c);
    $this->forward404Unless($ers);
    $this->eresource = $ers[0];
    
    $access      = $this->eresource->getAccessInfo();
    $affiliation = $this->getContext()->getAffiliation();
    
    if ( ! $access ) {
      $this->eresource->recordUsageAttempt( $affiliation->getOne(),
        false, 'no access information' );
      $this->forward404();
    }

    if ($this->eresource->getProductUnavailable()) {
      $this->eresource->recordUsageAttempt(
        $affiliation->getOne(), false, 'unavailable' );
      $this->setTemplate('unavailable');

      return;
    }

    // all clear to grant access
    
    $access_handler = BaseAccessHandler::factory(
      $this, $this->eresource, $affiliation );
    
    try {
      // FIXME: what about recording attempt when access fails in
      // AccessHandler?
      $this->eresource->recordUsageAttempt(
        $affiliation->getOne(), true );
      
      $access_handler->execute();
    }
    catch ( freermsUnauthorizedException $e ) {
      $this->setTemplate('unauthorized');
      return;
    }
  }

  public function executeRefer( sfWebRequest $request )
  {
    $this->forward404Unless(
      $this->title = $this->getUser()->getFlash('er_title'));
    
    $this->forward404Unless(
      $this->access_uri = $this->getUser()->getFlash('er_access_uri'));

    $this->referral_note = $this->getUser()->getFlash('er_referral_note');
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

    $affiliation = $this->getContext()->getAffiliation();
    
    if ( strpos( $url, $_SERVER['SERVER_NAME'] )) {
      $this->redirect( $url );
    }

    $user_libraries = LibraryPeer::retrieveByPKs(
      $affiliation->get() );
    
    $this->forward404Unless( $user_libraries );


    // FIXME: remove once we have our ebrary MARC records fixed
    if (strpos( $url, 'ebrary' ) !== false) {
      $this->redirect( $url );
    }

    if ( $affiliation->isOnsite() ) {
      $this->redirect( $url );
    }

    $proxy_url = freermsEZproxy::getEZproxyTicketUrl(
      $user_libraries[0], $url, $this->getUser()->getAttribute('username')
    );
    $this->redirect($proxy_url);
  }

  /**
   * @deprecated
   */
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
