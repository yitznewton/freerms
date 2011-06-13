<?php

class LibraryPeer extends BaseLibraryPeer
{
  /**
   * Returns the Library that is assigned the given IP address
   *
   * @param string $ip
   * @return Library
   */
  public static function retrieveByIp( $ip )
  {
    $num = @ip2long( $ip );

    if ( ! $num ) {
      throw new Exception( 'Invalid IP' );
    }

    $num = sprintf( '%u', $num );

    $c = new Criteria();
    $c->add( IpRangePeer::START_IP_INT, $num, Criteria::LESS_EQUAL );
    $c->add( IpRangePeer::END_IP_INT, $num, Criteria::GREATER_EQUAL );
    $c->add( IpRangePeer::ACTIVE_INDICATOR, true );

    $ip_ranges = IpRangePeer::doSelectJoinLibrary( $c );

    if ( $ip_ranges ) {
      $ip_range = $ip_ranges[0];
      
      return $ip_range->getLibrary();
    }
    
    return null;
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
  
  /**
   * @param array int[] $ids
   * @return array string[]
   */
  public static function getCodesForIds( array $ids )
  {
    $con = Propel::getConnection();
    
    $questionmarks = str_repeat( '?,', count($ids) - 1 ) . '?';
    
    $q = 'SELECT l.code FROM libraries l '
         . "WHERE l.id IN ($questionmarks)";
    
    $st = $con->prepare( $q );
    $st->execute( $ids );

    return $st->fetchAll( PDO::FETCH_COLUMN );
  }
  
  /**
   * Cycles through user's library ids, and returns first Library found
   *
   * @param freermsUserInterface $user
   * @return Library
   */
  public static function getFirstForUser( freermsUserInterface $user )
  {
    $library_ids = $user->getLibraryIds();
    
    for ( $i = 0; $i < count($library_ids); $i++ ) {
      if ( $library = LibraryPeer::retrieveByPK( $library_ids[$i] )) {
        return $library;
      }
    }
    
    return null;
  }
}
