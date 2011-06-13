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
   * @return array int[]
   */
  public function getLibraryIds()
  {
    // get users db library codes
    
    $c = new Criteria();
    $c->setDistinct();
    $c->addJoin( UserSiteAssocPeer::SITE_ID, SitePeer::ID );
    $c->addJoin( ProgramPeer::SITE_ID, SitePeer::ID );
    $c->add( UserSiteAssocPeer::USER_ID, $this->getId() );
    
    $q = 'SELECT DISTINCT sites.code FROM sites '
         . 'LEFT JOIN programs ON programs.site_id = sites.id '
         . 'LEFT JOIN user_site_assoc ON user_site_assoc.site_id = sites.id '
         . 'WHERE user_site_assoc.user_id = ? ';
    
    $st_args = array( $this->getId() );
    
    if ( $this->getProgramId() ) {
      $q .= 'OR programs.id = ? ';
      $st_args[] = $this->getProgramId();
    }
    
    $con = Propel::getConnection(
      SitePeer::DATABASE_NAME, Propel::CONNECTION_READ );
    
    $st = $con->prepare( $q );
    $st->execute( $st_args );
    
    $user_library_codes = $st->fetchAll( PDO::FETCH_COLUMN );

    // match with freerms library codes
    
    $c = new Criteria();
    $c->add( LibraryPeer::CODE, $user_library_codes, Criteria::IN );
    
    $libraries = LibraryPeer::doSelect( $c );
    
    $library_ids = array();
    
    foreach ( $libraries as $library ) {
      $library_ids[] = $library->getId();
    }

    return $library_ids;
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
