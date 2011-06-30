<?php

class Library extends BaseLibrary
{
  public function __toString()
  {
    return $this->getName();
  }
  
  public function save( PropelPDO $con = null ) {
    if ( $this->isNew() ) {
      $group = new sfGuardGroup();
    }
    else {
      $group = sfGuardGroupPeer::retrieveByPK( $this->getId() );
    }
    
    if ( ! $group ) {
      $msg = 'No sfGuardGroup for Library ' . $this->getId();
      throw new RuntimeException( $msg );
    }
    
    $group->setId( $this->getId() );
    $group->setName( $this->getCode() );
    $group->setDescription( $this->getName() );
    $group->save();
    
    parent::save($con);
  }
}
