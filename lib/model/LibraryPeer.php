<?php

class LibraryPeer extends BaseLibraryPeer
{
  public static function retrieveByIp( $ip )
  {
    $num = @ip2long( $ip );

    if ( ! $num ) {
      throw new Exception( 'Invalid IP' );
    }

    $c = new Criteria();
    $c->add( IpRangePeer::START_IP_INT, $num, Criteria::LESS_EQUAL );
    $c->add( IpRangePeer::END_IP_INT, $num, Criteria::GREATER_EQUAL );
    $c->add( IpRangePeer::ACTIVE_INDICATOR, true );

    $ip_ranges = IpRangePeer::doSelectJoinLibrary( $c );

    if ( $ip_ranges ) {
      $ip_range = $ip_ranges[0];
      
      return $ip_range->getLibrary();
    }
  }
  
  public static function retrieveKeyedArray()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(LibraryPeer::NAME);
    $libs = self::doSelect($c);
    
    $array = array();
    foreach ($libs as $l) {
      $array[$l->getId()] = $l->getName();
    }
    
    return $array;
  }
  
  public static function retrieveByCode($code)
  {
    $c = new Criteria();
    $c->add(LibraryPeer::CODE, $code);
    
    return self::doSelectOne($c);
  }
}
