<?php

class IpRange extends BaseIpRange
{
  public function save(PropelPDO $con = null) 
  {
    $start = $this->getStartIp();
    $end   = $this->getEndIp();
    
    if (ip2long($start) == ip2long($end)) {
      $this->setEndIp('');
    }
    
    return parent::save($con);  
  }
}