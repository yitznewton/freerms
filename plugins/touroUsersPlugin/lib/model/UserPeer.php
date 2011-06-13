<?php

class UserPeer extends BaseUserPeer
{
  /**
   * @param string $username 
   * @return User
   */
  public static function retrieveByUsername( $username )
  {
    $c = new Criteria();
    $c->add( UserPeer::USERNAME, $username );
    
    return UserPeer::doSelectOne( $c );
  }
}
