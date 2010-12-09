<?php
abstract class ScriptAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Custom script';

  public static function factory( sfAction $action )
  {
    $er = $action->getEResource();

    if ( ! $er ) {
      throw new UnexpectedValueException( 'Action EResource not found' );
    }

    $class_name = 'EResource' . $er->getId() . 'AccessHandler';

    if ( class_exists( $class_name ) ) {
      return new $class_name( $action );
    }
    else {
      $msg = 'Handler ' . $class_name . ' not found';
      throw new MissingAccessHandlerException( $msg );
    }
  }
}
