<?php

abstract class freermsBaseUser extends sfBasicSecurityUser
{
  protected $onsiteLibraryId;
  protected $username;

  abstract public function getLibraryIds();
  abstract public function checkPassword($password);

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername( $username )
  {
    if ( is_string( $username ) || $username === '' ) {
      return $this->username = $username;
    }
    else {
      $msg = 'Argument must be a non-empty string';
      throw new InvalidArgumentException( $msg );
    }
  }

  public function getOnsiteLibraryId()
  {
    if (isset( $this->onsiteLibraryId )) {
      return $this->getAttribute('onsiteLibraryId');
    }
    
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if ($user_ip == sfConfig::get('app_offsite-testing-ip')) {
      return $this->onsiteLibraryId = false;
    }
    
    $ip_ranges = IpRangePeer::doSelect(new Criteria());
    foreach ($ip_ranges as $range) {
      if (! $range->getEndIp() ) {
        // single IP
        
        if ($user_ip == $range->getStartIp()) {
          // match
          return $this->onsiteLibraryId = $range->getLibId();
        } else {
          continue;
        }
      }
      
      // not single IP
      
      if (IpRangePeer::isInRange(
        $user_ip, $range->getStartIp(), $range->getEndIp()
      )) {
        // match
        $library_id = $range->getLibId();
        return $this->onsiteLibraryId = $library_id;
      }
    }
    
    // no matches
    return $this->onsiteLibraryId = false;
  }
}
