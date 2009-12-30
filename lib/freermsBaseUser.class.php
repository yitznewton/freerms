<?php

class freermsBaseUser extends sfBasicSecurityUser
{
  public function getUsername()
  {
    return $this->getAttribute('username');
  }
  
  public function setUsername($username)
  {
    return $this->setAttribute('username', $username);
  }
  
  public function getOnsiteLibraryId()
  {
    if ($this->getAttribute('onsiteLibraryId') !== null) {
      return $this->getAttribute('onsiteLibraryId');
    }
    
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if ($user_ip == sfConfig::get('app_offsite-testing-ip')) {
      $this->setAttribute('onsiteLibraryId', false);
      return false;
    }
    
    $ip_ranges = IpRangePeer::doSelect(new Criteria());
    foreach ($ip_ranges as $range) {
      if (! $range->getEndIp() ) {
        // single IP
        
        if ($user_ip == $range->getStartIp()) {
          // match
          $this->setAttribute('onsiteLibraryId', $range->getLibId());
          return $range->getLibId();
        } else {
          continue;
        }
      }
      
      // not single IP
      
      if (IpRangePeer::isInRange(
        $user_ip, $range->getStartIp(), $range->getEndIp()
      )) {
        // match
        $library = $range->getLibId();
        $this->setAttribute('onsiteLibraryId', $library);
        return $library;
      }
    }
    
    // no matches
    $this->setAttribute('onsiteLibraryId', false);
    return false;
  }
}
