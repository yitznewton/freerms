<?php

class Acquisition extends BaseAcquisition
{
  public function __toString()
  {
    return $this->getNote();
  }
  
  public function delete(PropelPDO $con = null)
  {
    $this->setDeletedAt( time() );
    $this->save( $con );
  }
}
