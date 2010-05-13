<?php

class AccessInfoPeer extends BaseAccessInfoPeer
{
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		$criteria->add( self::DELETED_AT, null, Criteria::ISNULL );

    return parent::doSelectStmt( $criteria, $con );
	}
}
