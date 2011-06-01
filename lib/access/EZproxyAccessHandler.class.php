<?php

class EZproxyAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'EZproxy';
  
  /**
   * The first Library associated with the user
   *
   * @var Library
   */
  protected $library;
  
  public function execute()
  {
    if ( ! $this->getLibrary() ) {
      throw new RuntimeException( 'Unable to retrieve Library for user' );
    }
    
    $proxy_uri = EZproxyAccessHandler::composeTicketUrl(
      $this->getLibrary(),
      $this->getAccessUri(),
      $this->action->getUser()->getUsername()
    );

    $this->action->redirect( $proxy_uri );

    return;
  }
  
  protected function getLibrary()
  {
    if ( $this->library ) {
      return $this->library;
    }
    
    return $this->library
      = LibraryPeer::getFirstForUser( $this->action->getUser() );
  }
  
  static public function composeTicketUrl(Library $library, $access_url, $user = 'user', $encoding = 'md5' )
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
