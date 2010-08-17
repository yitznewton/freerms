<?php

class IpRangePeer extends BaseIpRangePeer
{
  public static function retrieveByLibraryId( $id )
  {
    $c = new Criteria();
    $c->add(IpRangePeer::LIB_ID, $id);
    $c->addAscendingOrderByColumn(IpRangePeer::PROXY_INDICATOR);
    $c->addAscendingOrderByColumn(IpRangePeer::START_IP_INT);

    return IpRangePeer::doSelect($c);
  }

  public static function retrieveOverlapping( IpRange $ip_range )
  {
    if ( ! $ip_range->getActiveIndicator() ) {
      return false;
    }

    $c = new Criteria();
    $c->add( IpRangePeer::ID, $ip_range->getId(), Criteria::NOT_EQUAL );
    $c->add( IpRangePeer::ACTIVE_INDICATOR, 1 );
    $c->add( IpRangePeer::START_IP_INT, $ip_range->getEndIpInt(), Criteria::LESS_EQUAL );
    $c->add( IpRangePeer::END_IP_INT, $ip_range->getStartIpInt(), Criteria::GREATER_EQUAL );
    
    return IpRangePeer::doSelect( $c );
  }

	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		$criteria->add( self::DELETED_AT, null, Criteria::ISNULL );

    return parent::doSelectStmt( $criteria, $con );
	}
}

class ipException extends Exception
{
}
