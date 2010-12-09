<?php

abstract class freermsBaseUser extends sfBasicSecurityUser
{
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

  public function getFirstLibrary()
  {
    $user_affiliation = $this->getLibraryIds();

    return LibraryPeer::retrieveByPK( $user_affiliation[0] );
  }

  public function clearUsername()
  {
    $this->setAttribute( 'username', null );
  }

  public function logout()
  {
    $this->getAttributeHolder()->clear();
    $this->setAuthenticated( false );
  }

  public function getOnsiteLibraryId()
  {
    if ( $this->getAttribute( 'onsiteLibraryId' ) ) {
      return $this->getAttribute( 'onsiteLibraryId' );
    }
    
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if ( $user_ip == sfConfig::get('app_offsite-testing-ip') ) {
      return $this->setOnsiteLibraryId( false );
    }

    if ( $library = LibraryPeer::retrieveByIp( $user_ip ) ) {
      return $this->setOnsiteLibraryId( $library->getId() );
    }
    
    // no matches
    return $this->setOnsiteLibraryId( false );
  }

  protected function setOnsiteLibraryId( $id )
  {
    $this->setAttribute( 'onsiteLibraryId', $id );
    return $id;
  }
}
