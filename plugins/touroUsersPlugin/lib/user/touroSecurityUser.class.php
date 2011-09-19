<?php

class touroSecurityUser extends sfGuardSecurityUser implements freermsUserInterface
{
  public function signIn($user, $remember = false, $con = null)
  {
    // signin
    $this->setAttribute('user_id', $user->getId(), 'sfGuardSecurityUser');
    $this->setAuthenticated(true);
    $this->clearCredentials();
    $this->addCredentials($user->getAllPermissionNames());

    // remember?
    if ($remember)
    {
      // remove old keys
      $c = new Criteria();
      $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);
      $c->add(sfGuardRememberKeyPeer::CREATED_AT, time() - $expiration_age, Criteria::LESS_THAN);
      sfGuardRememberKeyPeer::doDelete($c, $con);

      // remove other keys from this user
      $c = new Criteria();
      $c->add(sfGuardRememberKeyPeer::USER_ID, $user->getId());
      sfGuardRememberKeyPeer::doDelete($c, $con);

      // generate new keys
      $key = $this->generateRandomKey();

      // save key
      $rk = new sfGuardRememberKey();
      $rk->setRememberKey($key);
      $rk->setSfGuardUser($user);
      $rk->setIpAddress($_SERVER['REMOTE_ADDR']);
      $rk->save($con);

      // make key as a cookie
      $remember_cookie = sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember');
      sfContext::getInstance()->getResponse()->setCookie($remember_cookie, $key, time() + $expiration_age);
    }
  }

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
    return $this->getGuardUser()->getUsername();
  }
  
  /**
   * @return string
   */
  public function getProgramCode()
  {
    $guard_user = $this->getGuardUser();
    
    if ( ! $guard_user ) {
      return null;
    }
    
    $program = $guard_user->getProgram();
    
    if ( ! $program ) {
      return null;
    }
    
    return sprintf( '%-3s%-3s',
      $program->getTouroPgm(), $program->getTouroExt() );
  }
}
