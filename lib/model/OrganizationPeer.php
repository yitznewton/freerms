<?php

require 'lib/model/om/BaseOrganizationPeer.php';

class OrganizationPeer extends BaseOrganizationPeer
{
  public static function retrieveKeyedArray()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(OrganizationPeer::NAME);
    $orgs = self::doSelect($c);

    $array = array();        
    foreach ($orgs as $l) {
      $array[$l->getId()] = $l->getName();
    }
   
    return $array;
  }

  public static function retrieveHavingIpRegEvents()
  {
    $c = new Criteria();
    $c->addJoin( IpRegEventPeer::IP_RANGE_ID, IpRangePeer::ID );
    $c->addJoin( IpRangePeer::LIB_ID, AcqLibAssocPeer::LIB_ID );
    $c->addJoin( AcqLibAssocPeer::ACQ_ID, AcquisitionPeer::ID );
    $c->addJoin( AcquisitionPeer::VENDOR_ORG_ID, OrganizationPeer::ID );
    $c->addJoin( OrganizationPeer::IP_REG_METHOD_ID, IpRegMethodPeer::ID );
    $c->add( IpRegMethodPeer::LABEL, 'none', Criteria::NOT_EQUAL );

    return OrganizationPeer::doSelect( $c );
  }
}
