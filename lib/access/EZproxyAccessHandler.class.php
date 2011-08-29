<?php

class EZproxyAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = false;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION      = 'EZproxy';
  
  /**
   * The first Library associated with the user
   *
   * @var Library
   */
  protected $library;
  
  public function execute( sfAction $action)
  {
    $this->checkAffiliation();
    
    $class_name = get_class( $this );
    
    if ( ! $action->getUser()->isAuthenticated() ) {
      $action->forward(
        sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action') );

      return;
    }
    
    if ( ! $this->getLibrary() ) {
      $msg = 'Unable to retrieve Library for this user and EResource';
      throw new RuntimeException( $msg );
    }
    
    $proxy_uri = EZproxyAccessHandler::composeTicketUrl(
      $this->getLibrary(),
      $this->getAccessUri(),
      $action->getUser()->getGuardUser()->getUsername()
    );

    $action->redirect( $proxy_uri );

    return;
  }
  
  /**
   * 
   */
  protected function checkAffiliation()
  {
    if ( ! array_intersect(
      $this->affiliation->get(), $this->er->getLibraryIds()
    )) {
      throw new freermsUnauthorizedException();
    }
  }
  
  protected function getLibrary()
  {
    if ( $this->library ) {
      return $this->library;
    }
    
    $this->library = LibraryPeer::retrieveOneForEResourceAndAffiliation(
      $this->er, $this->affiliation );

    return $this->library;
  }
  
  static public function composeTicketUrl(
    Library $library, $access_url, $user = 'user', $encoding = 'md5' )
  {
    if ( ! $user ) {
      // blank or false
      $user = 'user';
    }

    if ($encoding != 'md5' && $encoding != 'sha1') {
      throw new Exception('Invalid encoding');
    }

    if ( ! is_string($access_url) ) {
      throw new Exception('Access URL must be a string');
    }

    $key = $library->getEzproxyKey();

    $proxyDate = '$c' . date('YmdHis');
    $proxyBlob = $encoding( $key . $user . $proxyDate );

    $proxyUrl = 'http://' . $library->getEzproxyHost() . '/login?user=';
    $proxyUrl .= $user . '&ticket=';
    $proxyUrl .= urlencode( $proxyBlob ) . urlencode( $proxyDate );
    $proxyUrl .= '&url=' . $access_url;

    return $proxyUrl;
  }
}
