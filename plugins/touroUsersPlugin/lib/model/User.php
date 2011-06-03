<?php

class User extends BaseUser
{
  /**
   * @return bool
   */
  public function isExpired()
  {
    return ( $this->getExpiresOn() < date('Y-m-d') );
  }
  
  /**
   * @param string $password
   * @return bool
   */
  public function checkPassword( $password )
  {
    return ( sha1($password) == $this->getPassword() );
  }
}
