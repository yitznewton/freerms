<?php

class freermsPropelUser extends freermsBaseUser
{
  protected $user;
  protected $libraryIds;

  public function checkPassword( $password )
  {
    if ($this->isAuthenticated()) {
      return true;
    }

    if ( ! is_string( $password ) || $password === '' ) {
      $msg = 'Argument must be a non-empty string';
      throw new InvalidArgumentException( $msg );
    }

    if ( ! $this->getUsername() ) {
      throw new Exception( 'Username must be set first' );
    }

    $c = new Criteria();
    $c->add( UserPeer::USERNAME, $this->getUsername() );
    $c->add( UserPeer::PASSWORD, sha1( $password ) );
    $users = UserPeer::doSelectJoinAll( $c );

    if (!$users) {
      return false;
    }

    return $this->user = $users[0];
  }

  public function getLibraryIds()
  {
    if (isset( $this->libraryIds )) {
      return $this->libraryIds;
    }
    
    if ( ! $this->user ) {
      return false;
    }
    
    $library_ids = array();

    $program = $this->user->getProgram();

    if ($program) {
      $library = $program->getLibrary();

      if ($library) {
        $library_ids[] = $library->getId();
      }
    }

    $sites = $this->user->getUserSiteAssocsJoinSite();

    if ($sites) {
      foreach ($sites as $site) {
        $library_ids[] = $site->getId();
      }
    }

    return $this->libraryIds = $library_ids;
  }

  public function getCredentials()
  {
    if ( ! $this->user ) {
      return false;
    }

    $credentials = array();

    $groups = $this->user->getUserGroupAssocsJoinGroup();

    if ($groups) {
      foreach ($groups as $group) {
        $credentials[] = $group->getName();
      }
    }

    return $this->credentials = $credentials;
  }
}