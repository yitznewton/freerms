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

    // copy a "before" picture of the IpRange for IpRegEvent processing
    $old_this = clone $this;

    $ret = parent::save( $con );

    if ( $this->isNew() ) {
      IpRegEventPeer::fromNew( $this );
    }
    elseif ( $this->getDeletedAt() ) {
      IpRegEventPeer::fromDeleted( $this );
    }
    elseif ( $this->isModified() ) {
      $old_this->reload();
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
