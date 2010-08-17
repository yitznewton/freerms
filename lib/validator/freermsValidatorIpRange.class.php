<?php

class freermsValidatorIpRange extends sfValidatorBase
{
  protected function configure( $options = array(), $messages = array() )
  {
    parent::configure( $options, $messages );

    $this->addMessage( 'conflicting', 'Range conflicts with an existing range' );
    $this->addMessage( 'inverted', 'Ending IP cannot be lower than starting IP' );
  }

  protected function doClean( $values )
  {
    $start = sprintf( '%u', @ip2long( $values['start_ip'] ) );
    $end   = sprintf( '%u', @ip2long( $values['end_ip'] ) );

    if ( $end < $start ) {
      throw new sfValidatorError( $this, 'inverted' );
    }

    $test_ip_range = new IpRange();
    $test_ip_range->setId( $values['id'] );
    $test_ip_range->setActiveIndicator( $values['active_indicator'] );
    $test_ip_range->setStartIp( $values['start_ip'] );
    $test_ip_range->setEndIp( $values['end_ip'] );

    $conflict_ranges = IpRangePeer::retrieveOverlapping( $test_ip_range );

    if ( $conflict_ranges && count( $conflict_ranges ) > 1 ) {
      $this->setMessage( 'conflicting', 'Range conflicts with multiple existing ranges' );
      throw new sfValidatorError( $this, 'conflicting' );
    }
    elseif ( $conflict_ranges ) {
      $this->setMessage( 'conflicting', 'Range conflicts with existing range ' . $conflict_ranges[0] );
      throw new sfValidatorError( $this, 'conflicting' );
    }

    return $values;
  }
}
