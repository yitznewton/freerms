<?php

class touroSecurityUser extends sfGuardSecurityUser implements freermsUserInterface
{
  public function getGuardUser()
  {
    if (
      ! $this->user
      && $id = $this->getAttribute('user_id', null, 'sfGuardSecurityUser')
    ) {
      $this->user = UserPeer::retrieveByPk( $id );

      if ( ! $this->user )
      {
        // the user does not exist anymore in the database
        $this->signOut();

        throw new sfException('The user does not exist anymore in the database.');
      }
    }

    return $this->user;
  }

  /**
   * @return array int[]
   */
  public function getLibraryIds()
  {
    if ( ! $this->isAuthenticated() ) {
      return array();
    }
    elseif ( $user = $this->getGuardUser() ) {
      return $this->getGuardUser()->getLibraryIds();
    }
    else {
      return array();
    }
  }
  
  public function getUsername()
  {
    throw new Exception('f');
  }
}
