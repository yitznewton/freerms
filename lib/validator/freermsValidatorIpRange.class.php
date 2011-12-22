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
    if (empty($values['end_ip'])) {
      $values['end_ip'] = $values['start_ip'];
    }

    $start = IpRange::createSortString($values['start_ip']);
    $end   = IpRange::createSortString($values['end_ip']);

    if ($end < $start) {
      throw new sfValidatorError($this, 'inverted');
    }

    if ($values['is_active'] && !$values['is_excluded']) {
      $this->doTestIntersecting($values);
    }

    return $values;
  }

  protected function doTestIntersecting(array $values)
  {
    $test_ip_range = new IpRange();
    $test_ip_range->fromArray($values);

    $conflict_ranges = Doctrine_Core::getTable('IpRange')
      ->findIntersecting($test_ip_range);

    if ( $conflict_ranges->count() > 1 ) {
      $this->setMessage( 'conflicting', 'Range conflicts with multiple existing ranges' );
      throw new sfValidatorError( $this, 'conflicting' );
    }
    elseif ( $conflict_ranges->count() == 1 ) {
      $this->setMessage( 'conflicting', 'Range conflicts with existing range ' . $conflict_ranges[0] );
      throw new sfValidatorError( $this, 'conflicting' );
    }
  }
}

