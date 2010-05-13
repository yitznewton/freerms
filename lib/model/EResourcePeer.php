<?php

class EResourcePeer extends BaseEResourcePeer
{
  public static function retrieveByLibraryId($id, Criteria $c = null)
  {
    if (!$c) {
      $c = new Criteria();
    }

    $c->addJoin(EResourcePeer::ACQ_ID, AcqLibAssocPeer::ACQ_ID);
    $c->add(AcqLibAssocPeer::LIB_ID, $id);
    $c->addAscendingOrderByColumn(EResourcePeer::TITLE);

    return EResourcePeer::doSelect($c);
  }

  public static function retrieveByVendorOrgId($id, Criteria $c = null)
  {
    if (!$c) {
      $c = new Criteria();
    }

    $c->addJoin(EResourcePeer::ACQ_ID, AcquisitionPeer::ID);
    $c->add(AcquisitionPeer::VENDOR_ORG_ID, $id);    
    $c->addAscendingOrderByColumn(EResourcePeer::TITLE);
    
    return EResourcePeer::doSelect($c);
  }

  public static function doSelect(Criteria $criteria, PropelPDO $con = null)
  {
    $criteria->add(EResourcePeer::DELETED_AT, null, Criteria::ISNULL);
    return parent::doSelect($criteria, $con);
  }  
 
  public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
  {
	  $criteria->add(EResourcePeer::DELETED_AT, null, Criteria::ISNULL);
    return parent::doCount($criteria, $con);
  }

	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		$criteria->add( self::DELETED_AT, null, Criteria::ISNULL );

    return parent::doSelectStmt( $criteria, $con );
	}
}
