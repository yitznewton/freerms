<?php

class AcquisitionPeer extends BaseAcquisitionPeer
{
  public static function fromIpRange( IpRange $ip_range )
  {
    $c = new Criteria();
    $c->addJoin( AcqLibAssocPeer::ACQ_ID, AcquisitionPeer::ID );
    $c->add( AcqLibAssocPeer::LIB_ID, $ip_range->getLibId() );

    return AcquisitionPeer::doSelect( $c );
  }
}
