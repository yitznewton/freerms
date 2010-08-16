<?php

abstract class freermsBaseUser extends sfBasicSecurityUser
{
  protected $onsiteLibraryId;

  abstract public function getLibraryIds();
  abstract public function checkPassword($password);

  public function getUsername()
  {
    return $this->getAttribute('username');
  }

  public function setUsername( $username )
  {
    if ( is_string( $username ) || $username === '' ) {
      $this->setAttribute( 'username', $username );
    }
    else {
      $msg = 'Argument must be a non-empty string';
      throw new InvalidArgumentException( $msg );
    }
  }

  public function getOnsiteLibraryId()
  {
    if (isset( $this->onsiteLibraryId )) {
      return $this->onsiteLibraryId;
    }
    
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if ( $user_ip == sfConfig::get('app_offsite-testing-ip') ) {
      return $this->onsiteLibraryId = false;
    }

    if ( $library = LibraryPeer::retrieveByIp( $user_ip ) ) {
      return $this->onsiteLibraryId = $library->getId();
    }
    
    // no matches
    return $this->onsiteLibraryId = false;
  }
}
