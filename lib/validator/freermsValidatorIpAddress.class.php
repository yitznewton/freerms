<?php

class freermsValidatorIpAddress extends sfValidatorString
{
  protected function configure( $options = array(), $messages = array() )
  {
    parent::configure( $options, $messages );

    $this->setMessage( 'invalid', 'Invalid IP address' );
  }

  protected function doClean( $value )
  {
    $int = @ip2long( $value );

    if ( ! $int ) {
      throw new sfValidatorError( $this, 'invalid' );
    }

    return parent::doClean( $value );
  }
}
