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
    $affiliation   = $this->getContext()->getAffiliation();
    $subject_slug  = $request->getParameter('subject');
    
    if ( $subject_slug ) {
      $this->subject = DbSubjectPeer::retrieveBySlug( $subject_slug );
    }
    else {
      $this->subject = null;
    }
    
    if ( $this->subject ) {
      $this->featured_dbs = EResourcePeer::retrieveByAffiliationAndSubject(
        $affiliation->get(), $this->subject, true );
    }
    else {
      $this->featured_dbs = array();
    }

    $this->subject_default = $subject_slug;
    $this->subject_widget  = new DbSubjectWidgetFormChoice();

    $this->databases = EResourcePeer::retrieveByAffiliationAndSubject(
      $affiliation->get(), $this->subject );
  }

  public function executeAccess(sfWebRequest $request)
  {
    $c = new Criteria();

    if ( $request->hasParameter('id') ) {
      $c->add( EResourcePeer::ID, $request->getParameter('id') );
    }
    else if ( $request->hasParameter('alt_id' ) ) {
      $c->add( EResourcePeer::ALT_ID, $request->getParameter('alt_id'),
        Criteria::LIKE );
    }
    else {
      $this->forward404();
    }

    $ers = EResourcePeer::doSelectJoinAccessInfo( $c );
    $this->forward404Unless( $ers );
    $this->er = $ers[0];
    
    $access      = $this->er->getAccessInfo();
    $affiliation = $this->getContext()->getAffiliation();
    
    if ( ! $access ) {
      $msg = 'EResource ' . $this->er->getId() . ' lacks AccessInfo';
      throw new RuntimeException( $msg );
    }

    if ( $this->er->getProductUnavailable() ) {
      $this->er->recordUsageAttempt(
        $affiliation->getOne(), false, 'unavailable' );
      
      $this->setTemplate('unavailable');

      return;
    }

    // all clear to grant access
    
    $access_handler = BaseAccessHandler::factory( $this->er, $affiliation );
    
    try {
      // FIXME: what about recording attempt when access fails in
      // AccessHandler?
      $this->er->recordUsageAttempt( $affiliation->getOne(), true );
      $access_handler->execute( $this );
    }
    catch ( freermsUnauthorizedException $e ) {
      $this->title = $er->getTitle();
      $this->setTemplate('unauthorized');
      return; 
    }
  }

  public function executeRefer( sfWebRequest $request )
  {
    $this->forward404Unless(
      $this->access_uri = $this->getUser()->getFlash('er_access_uri'));

    // may be null if coming from directRefer
    $this->title = $this->getUser()->getFlash('er_title');
    
    $this->referral_note = $this->getUser()->getFlash('er_referral_note');
  }

  /**
   * This method passes a client-specified URL for referral
   *
   * @param sfWebRequest $request 
   */
  public function executeDirectRefer(sfWebRequest $request)
  {
    $raw_url = $request->getUri();
    $url = substr( $raw_url, strpos($raw_url, '/direct-refer/') + 14 );
    
    $this->getUser()->setFlash('er_id', null);
    $this->getUser()->setFlash('er_access_uri', $url);
    $this->redirect('database/refer');
  }
  
  public function executeDirectUrl(sfWebRequest $request)
  {
    $raw_url = $request->getUri();
    $url     = substr( $raw_url, strrpos($raw_url, '/url/') + 5 );

    $affiliation = $this->getContext()->getAffiliation();
    
    if ( strpos( $url, $_SERVER['SERVER_NAME'] )) {
      // multiple references to the FreERMS host
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

    $proxy_url = EZproxyAccessHandler::composeTicketUrl(
      $user_libraries[0], $url,
      $this->getUser()->getGuardUser()->getUsername()
    );
    
    $this->redirect($proxy_url);
  }

  /**
   * @deprecated
   */
  public function executeHandleUnauthorized()
  {
    $this->title = $this->getUser()->getFlash('title');
  }
  
  /**
   * @deprecated
   * @param sfWebRequest $request 
   */
  public function executeUnavailableHandler(sfWebRequest $request)
  {
    $this->title = $this->getUser()->getFlash('title');
  }
}
