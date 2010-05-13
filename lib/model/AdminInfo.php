<?php

class AdminInfo extends BaseAdminInfo
{
	public function delete(PropelPDO $con = null)
  {
    $this->setDeletedAt( time() );
    $this->save( $con );
  }
}
