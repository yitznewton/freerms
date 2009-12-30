<?php

class freermsLDAPUser extends freermsBaseUser implements freermsUserInterface
{
  public function getUsername()
  {
    return $this->getAttribute('username');
  }
  
  public function setUsername($username)
  {
    if (! is_string($username) || strlen($username) < 1 ) {
      throw new Exception('Username must be a non-empty string');
    }
    
    if ($this->getAttribute('username')) {
      throw new Exception('Username cannot be changed once set');
    }
    
    return $this->setAttribute('username', $username);
  }
  
  public function checkPassword($password)
  {
    if ($this->isAuthenticated()) {
      return true;
    }
    
    if (! is_string($password) || strlen($password) < 1 ) {
      throw new Exception('Password must be a non-empty string');
    }
    
    if (! $this->getAttribute('username') ) {
      throw new Exception('Username must be set first');
    }
    
    $dn = sprintf(
      sfConfig::get('app_ldap_user-dn-mask'),
      $this->getAttribute('username')
    );
    try {
      $bind = freermsLDAP::bind($dn, $password);
    } catch (Exception $e) {
      return $e;
    }

    return $bind;
  }
  
  public function getLibraryId()
  {
    $this->isOnsite();  // this will affect libraryId
    
    // false and null NOT the same here
    if ($this->getAttribute('libraryId') !== null) {
      return $this->getAttribute('libraryId');
    }
    
    $organizationalUnits = $this->getOrganizationalUnits();
    
    $libraries = LibraryPeer::doSelect(new Criteria());
    foreach ($libraries as $l) {
      if (in_array($l->getCode(), $organizationalUnits)) {
        $this->setAttribute('libraryId', $l->getId());
        return $l->getId();
      }
    }
    
    $this->setAttribute('libraryId', false);
    return false;
  }
  
  public function retrieveCredentials()
  {
    if ($this->listCredentials()) {
      return $this->listCredentials();
    }
    
    return $this->addCredentials( $this->getGroupsHaving() );
  }
  
  protected function getOrganizationalUnits()
  {
    $username = $this->getUsername();
    
    $filter = sprintf(sfConfig::get('app_ldap_user-search-mask'), $username);
    $return_fields = array('ou');
    
    try {
      $result = freermsLDAP::getSearchResults($filter, $return_fields);
    } catch (Exception $e) {
      return $e;
    }
    
    // there can only be one result, as uid is unique key
    $ou_array_raw = $result[0]['ou'];
    
    // build cleaned-up array
    $ou_array_processed = array();
    for ($i=0; $i < $ou_array_raw['count']; $i++) {
      $ou_array_processed[] = $ou_array_raw[$i];
    }
    
    return $this->organizationalUnits = $ou_array_processed;
  }
  
  protected function getGroupsHaving()
  {
    if ($this->getAttribute('groupsHaving')) {
      // already retrieved
      return split(',', $this->getAttribute('groupsHaving'));
    }
    
    $username = $this->getAttribute('username');

    $dn = sprintf(
      sfConfig::get('app_ldap_user-dn-mask'),
      $this->getAttribute('username')
    );
    
    $filter = sprintf(sfConfig::get('app_ldap_group-search-mask'), $dn);
    $return_fields = array('cn');
    
    $result = freermsLDAP::getSearchResults($filter, $return_fields);

    // build cleaned-up array
    $group_array_processed = array();
    for ($i=0; $i < $result['count']; $i++) {
      $group = $result[$i]['cn'][0];
      $prefix = substr($group, 0, strpos($group, '_'));

      if ( !sfConfig::get('app_ldap_group-prefix') ) {
        $group_array_processed[] = $group;
      } elseif ($prefix == sfConfig::get('app_ldap_group-prefix')) {
        $group_array_processed[] = substr($group, strpos($group, '_')+1);
      }
    }
    
    $this->setAttribute('groupsHaving', join(',', $group_array_processed));
    return $group_array_processed;
  }
}