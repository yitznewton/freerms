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
   * Returns first Library found for given freermsUserAffiliation
   *
   * @param freermsUserAffiliation $affiliation
   * @return Library
   */
  public static function retrieveOneForAffiliation(
    freermsUserAffiliation $affiliation )
  {
    foreach ( $affiliation->get() as $id ) {
      if ( $library = LibraryPeer::retrieveByPK( $id )) {
        return $library;
      }
    }
    
    return null;
  }
  
  public static function retrieveOneForEResourceAndAffiliation(
    EResource $er, freermsUserAffiliation $affiliation)
  {
    $er_lib_ids   = $er->getLibraryIds();
    $user_lib_ids = $affiliation->get();
    
    // array_values() to reset keys
    $common = array_values( array_intersect( $er_lib_ids, $user_lib_ids ));
    
    if ( $common && $library = LibraryPeer::retrieveByPK( $common[0] )) {
      return $library;
    }
    else {
      return null;
    }
  }
  
  /**
   * Returns whether ShowFeaturedSubjects is set on any of the Librarys with
   * the given ids
   * 
   * @deprecated
   * @param array int[] $ids 
   * @return boolean
   */
  public static function isAnyShowFeaturedSubjects( array $ids )
  {
    $c = new Criteria();
    $c->add( LibraryPeer::SHOW_FEATURED_SUBJECTS, 1 );
    $c->add( LibraryPeer::ID, $ids, Criteria::IN );
    
    return LibraryPeer::doSelect( $c ) ? true : false;
  }
}
