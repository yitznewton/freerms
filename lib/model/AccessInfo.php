<?php

class AccessInfo extends BaseAccessInfo
{
  public function __toString()
  {
    return $this->getOnsiteAccessUri();
  }

	public function delete(PropelPDO $con = null)
  {
    $this->setDeletedAt( time() );
    $this->save( $con );
  }
}
