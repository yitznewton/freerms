<?php

class IpRange extends BaseIpRange
{
  public function __toString()
  {
    return $this->getStartIp() . '--' . $this->getEndIp();
  }

  public function setStartIp( $v )
  {
    if ( $v ) {
      $num = @ip2long( $v );

      if ( ! $num ) {
        throw new Exception( 'Invalid' );
      }

      $num = sprintf( '%u', $num );

      $this->setStartIpInt( $num );
    }

    return parent::setStartIp( $v );
  }

  public function setEndIp( $v )
  {
    if ( $v ) {
      $num = @ip2long( $v );

      if ( ! $num ) {
        throw new Exception( 'Invalid' );
      }

      $num = sprintf( '%u', $num );
      
      $this->setEndIpInt( $num );
    }

    return parent::setEndIp( $v );
  }

  /**
   * Bypass type casting to prevent the unsigned integer being corrupted on
   * 32-bit platforms
   *
   * @param int $v
   * @return IpRange
   */
  public function setStartIpInt($v)
  {
    if ($this->start_ip_int !== $v) {
      $this->start_ip_int = $v;
      $this->modifiedColumns[] = IpRangePeer::START_IP_INT;
    }

    return $this;
  }

  /**
   * Bypass type casting to prevent the unsigned integer being corrupted on
   * 32-bit platforms
   *
   * @param int $v
   * @return IpRange
   */
  public function setEndIpInt($v)
  {
    if ($this->end_ip_int !== $v) {
      $this->end_ip_int = $v;
      $this->modifiedColumns[] = IpRangePeer::END_IP_INT;
    }

    return $this;
  }

  public function save(PropelPDO $con = null) 
  {
    $start = $this->getStartIp();
    $end   = $this->getEndIp();

    if ( ! $end ) {
      // this needs to be set for Library::retrieveByIp() etc.
      $this->setEndIp( $this->getStartIp() );
    }

    // copy a "before" picture of the IpRange
    $old_this = clone $this;
    $ret      = null;

    if ( $this->isNew() ) {
      $ret = parent::save( $con );
      IpRegEventPeer::fromNew( $this );
    }
    elseif ( $this->getDeletedAt() ) {
      $ret = parent::save( $con );
      IpRegEventPeer::fromDeleted( $this );
    }
    elseif ( $this->isModified() ) {
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
