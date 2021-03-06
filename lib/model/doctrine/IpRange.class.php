<?php

/**
 * IpRange
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    freerms
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class IpRange extends BaseIpRange
{
  public function __toString()
  {
    $ret = $this->getStartIp();

    if ($this->getEndIp() && $this->getEndIp() != $this->getStartIp()) {
      $ret .= '-' . $this->getEndIp();
    }

    return $ret;
  }

  public function setStartIp($v)
  {
    if (!@ip2long($v)) {
      throw new InvalidArgumentException("Invalid IP $v");
    }
    
    $this->_set('start_ip_sort', IpRange::createSortString($v));
    $this->_set('start_ip', $v);

    if (is_null($this->end_ip)) {
      $this->setEndIp($v);
    }
  }

  public function setEndIp($v)
  {
    if (!@ip2long($v)) {
      throw new InvalidArgumentException("Invalid IP $v");
    }
    
    $this->_set('end_ip_sort', IpRange::createSortString($v));
    $this->_set('end_ip', $v);
  }

  public static function createSortString($ip)
  {
    $segments = array_map(function($v) {
      return sprintf('%03d', $v);
    }, explode('.', $ip));

    return implode('', $segments);
  }
}

