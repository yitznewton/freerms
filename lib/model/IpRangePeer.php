<?php

class IpRangePeer extends BaseIpRangePeer
{
  public static function retrieveIpsByLibraryId($id)
  {
    $c = new Criteria();
    $c->add(IpRangePeer::LIB_ID, $id);
    $c->addAscendingOrderByColumn(IpRangePeer::PROXY_INDICATOR);
    $c->addAscendingOrderByColumn(IpRangePeer::START_IP);    

    return IpRangePeer::doSelect($c);
  }

  public static function retrieveUnregisteredAutoEmail()
  {
    $c = new Criteria();

    $c->setDistinct();
    $c->addJoin( IpRangePeer::ID, IpRegEventPeer::IP_RANGE_ID );
    $c->addJoin( IpRangePeer::LIB_ID, LibraryPeer::ID );
    $c->addJoin( LibraryPeer::ID, AcqLibAssocPeer::LIB_ID );
    $c->addJoin( AcqLibAssocPeer::ACQ_ID, AcquisitionPeer::ID );
    $c->addJoin( AcquisitionPeer::ID, EResourcePeer::ACQ_ID );
    $c->addJoin( AcquisitionPeer::VENDOR_ORG_ID, OrganizationPeer::ID );
    $c->addJoin( OrganizationPeer::IP_REG_METHOD_ID, IpRegMethodPeer::ID );
    $c->addJoin( OrganizationPeer::ID, ContactPeer::ORG_ID );
    $c->add( EResourcePeer::SUPPRESSION, false );
    $c->add( OrganizationPeer::IP_REG_FORCE_MANUAL, false );
    $c->add( IpRegMethodPeer::LABEL, 'email' );
    $c->add( ContactPeer::EMAIL, null, Criteria::ISNOTNULL );

    return IpRangePeer::doSelect( $c );
  }

  public static function isInRange($testIP, $startIP, $endIP) 
  {
    if (! $testIP = @ip2long($testIP)) {
      throw new Exception('Test IP not valid');
    }

    if (! $startIP = @ip2long($startIP)) {
      throw new Exception('Start IP not valid');
    }

    if (! $endIP = @ip2long($endIP)) {
      throw new Exception('End IP not valid');
    }

    if ( ($testIP >= $startIP) && ($testIP <= $endIP) ) {
      return true;
    } else {
      return false;
    }
  }

  public static function doRangesIntersect($start1, $end1, $start2, $end2)
  {
    if (! $start1 = @ip2long($start1)) {
      throw new ipException('First starting IP not valid');
    }
    
    if ($end1 && !($end1 = @ip2long($end1))) {
      throw new ipException('First ending IP not valid');
    }
    
    if (! $start2 = @ip2long($start2)) {
      throw new ipException('Second starting IP not valid');
    }
    
    if ($end2 && !($end2 = @ip2long($end2))) {
      throw new ipException('Second starting IP not valid');
    }
    
    if (!$end1 && !$end2) {
      // both are single IP addresses
      return ($start1 == $start2);
    }
    
    if (!$end1) {
      // first is single
      return ($start1 >= $start2 && $start1 <= $end2);
    }
    
    if (!$end2) {
      // second is single
      return ($start2 >= $start1 && $start2 <= $end1);
    }
    
    if (ip2long($start1) > ip2long($end1)) {
      return true;
    }
    // must be both are ranges
    elseif (
      ($start1 >= $start2 && $start1 <= $end2)
      || ($end1 >= $start2 && $end1 <= $end2)
      || ($start2 >= $start1 && $start2 <= $end1)
      || ($end2 >= $start1 && $end2 <= $end1)
    ) {
      return true;
    }    
    else {
      return false;  
    }
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
