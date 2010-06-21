<?php

class IpRange extends BaseIpRange
{
  public function __toString()
  {
    return $this->getStartIp() . '--' . $this->getEndIp();
  }

  public function save(PropelPDO $con = null) 
  {
    $start = $this->getStartIp();
    $end   = $this->getEndIp();
    
    if (ip2long($start) == ip2long($end)) {
      $this->setEndIp('');
    }

    $ret = null;

    // copy a "before" picture of the IpRange for IpRegEvent processing
    $old_this = clone $this;
    
    if ( $this->isNew() ) {
      $ret = parent::save( $con );
      $old_this->setId( $this->getId() );
      $this->doIpRegNew( $old_this );
    }
    elseif ( $this->getDeletedAt() ) {
      $old_this->reload();
      $ret = parent::save( $con );
      $this->doIpRegDeleted( $old_this );
    }
    elseif ( $this->isModified() ) {
      $old_this->reload();
      $ret = parent::save( $con );
      $this->doIpRegModified( $old_this );
    }
    
    return $ret;
  }

  public function delete(PropelPDO $con = null)
  {
    $this->setDeletedAt( time() );
    $this->save( $con );
  }

  protected function doIpRegNew( IpRange $old_this )
  {
    $ip_reg_event = new IpRegEvent();
    $ip_reg_event->initialize( $old_this );

    $ip_reg_event->setNewStartIp( $this->getStartIp() );
    $ip_reg_event->setNewEndIp( $this->getEndIp() );
    $ip_reg_event->save();
  }

  protected function doIpRegModified( IpRange $old_this )
  {
    $ip_reg_event = $this->getIpRegEvent();

    if ( $ip_reg_event ) {
      $ip_reg_event->setNewStartIp( $this->getStartIp() );
      $ip_reg_event->setNewEndIp( $this->getEndIp() );
      $ip_reg_event->save();
    }
    else {
      $ip_reg_event = new IpRegEvent();
      $ip_reg_event->initialize( $old_this );

      $ip_reg_event->setNewStartIp( $this->getStartIp() );
      $ip_reg_event->setNewEndIp( $this->getEndIp() );
      $ip_reg_event->save();
    }
  }

  protected function doIpRegDeleted( IpRange $old_this )
  {
    $ip_reg_event = $this->getIpRegEvent();

    if ( $ip_reg_event && ! $ip_reg_event->getOldStartIp() ) {
      // deleting a newly-added IpRange
      $ip_reg_event->delete();
    }
    elseif ( $ip_reg_event ) {
      $ip_reg_event->setNewStartIp( null );
      $ip_reg_event->setNewEndIp( null );
      $ip_reg_event->save();
    }
    else {
      $ip_reg_event = new IpRegEvent();
      $ip_reg_event->initialize( $old_this );

      $ip_reg_event->setOldStartIp( $old_this->getStartIp() );
      $ip_reg_event->setOldEndIp( $old_this->getEndIp() );
      $ip_reg_event->save();
    }
  }
}