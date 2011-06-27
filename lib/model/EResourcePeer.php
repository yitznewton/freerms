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
  
  /**
   * Returns an array of EResources which are set as featured for the given
   * subject, and available at the given Librarys
   *
   * @param array int[] $library_ids
   * @param DbSubject $subject
   * @param bool $featured_only
   * @return array EResource[]
   */
  public static function retrieveByAffiliationAndSubject(
    array $library_ids, DbSubject $subject = null, $featured_only = false )
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->addJoin( AcqLibAssocPeer::ACQ_ID, AcquisitionPeer::ID );
    $c->addJoin( LibraryPeer::ID, AcqLibAssocPeer::LIB_ID );
    $c->addJoin( AcquisitionPeer::ID, EResourcePeer::ACQ_ID );
    $c->add( LibraryPeer::ID, $library_ids, Criteria::IN );
    $c->add( EResourcePeer::SUPPRESSION, 0 );
    
    if ( $subject ) {
      $c->addJoin( EResourcePeer::ID, EResourceDbSubjectAssocPeer::ER_ID );
      $c->add( EResourceDbSubjectAssocPeer::DB_SUBJECT_ID,
        $subject->getId() );
      
      if ( $featured_only ) {
        $c->add( EResourceDbSubjectAssocPeer::FEATURED_WEIGHT, -1,
          Criteria::NOT_EQUAL );
        $c->add( LibraryPeer::SHOW_FEATURED_SUBJECTS, 1 );
        $c->addAscendingOrderByColumn(
          EresourceDbSubjectAssocPeer::FEATURED_WEIGHT );
      }
    }
    
    $c->addAscendingOrderByColumn(
      EResourcePeer::SORT_TITLE );
    
    return EResourcePeer::doSelect( $c );
  }
  
  public static function retrieveHomeFeatured()
  {
    $c = new Criteria();
    $c->add( EResourcePeer::IS_FEATURED, 1 );
    $c->addAscendingOrderByColumn( EResourcePeer::FEATURED_WEIGHT );
    
    return EResourcePeer::doSelect( $c );
  }

  public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
  {
	  $criteria->add(EResourcePeer::DELETED_AT, null, Criteria::ISNULL);
    return parent::doCount($criteria, $con);
  }

	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		$criteria->add( EResourcePeer::DELETED_AT, null, Criteria::ISNULL );

    return parent::doSelectStmt( $criteria, $con );
	}
}
