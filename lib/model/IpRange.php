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

    // copy a "before" picture of the IpRange
    $old_this    = clone $this;
    $is_new      = $this->isNew();
    $is_modified = $this->isModified();

    if ( $is_new ) {
      $ret = parent::save( $con );
      IpRegEventPeer::fromNew( $this );
    }
    elseif ( $this->getDeletedAt() ) {
      $ret = parent::save( $con );
      IpRegEventPeer::fromDeleted( $this );
    }
    elseif ( $is_modified ) {
      $old_this->reload();
      $ret = parent::save( $con );

      IpRegEventPeer::fromModified( $old_this, $this );
    }

    return $ret;
  }

  public function delete(PropelPDO $con = null)
  {
    $this->setDeletedAt( time() );
    $this->save( $con );
  }
}
