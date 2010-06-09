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

    return OrganizationPeer::doSelect( $c );
  }

  public static function retrieveByEResource($id, Criteria $c = null)
  {
    $c = new Criteria();
    $c->add(EResourcePeer::ADMIN_INFO_ID, $id);
    $c->addJoin(EResourcePeer::ADMIN_INFO_ID, AdminInfoPeer::ID);   
    $c->addJoin(EResourcePeer::ACQ_ID, AcquisitionPeer::ID);   
    $c->addJoin(AcquisitionPeer::VENDOR_ORG_ID, OrganizationPeer::ID);

    return OrganizationPeer::doSelectOne( $c );
  }
}
