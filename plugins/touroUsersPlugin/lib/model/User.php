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
   * @return array string[]
   */
  public function getAllPermissionNames()
  {
    $c = new Criteria();
    $c->addJoin( UserGroupAssocPeer::GROUP_ID, GroupPeer::ID );
    $c->add( UserGroupAssocPeer::USER_ID, $this->getId() );
    
    $groups = GroupPeer::doSelect( $c );
    $names  = array();
    
    foreach ( $groups as $group ) {
      $names[] = $group->getName();
    }
    
    return $names;
  }
  
  /**
   * This has no equivalent in the Touro user database, so return false
   *
   * @return bool
   */
  public function getIsSuperAdmin()
  {
    return false;
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
