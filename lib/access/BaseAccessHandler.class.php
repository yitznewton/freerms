<?php

class BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Open or IP-based';

  protected $action;
  protected $isOnsite;

  protected function __construct( sfAction $action )
  {
    $this->action = $action;
    $this->isOnsite = $action->getUser()->getOnsiteLibraryId() ? true : false;
  }

  public function execute()
  {
    if ( $this->isOnsite ) {
      $method = 'getOnsiteAccessUri';
    }
    else {
      $method = 'getOffsiteAccessUri';
    }

    $this->action->redirect( $this->action->getEResource()->getAccessInfo()->$method() );

    return;
  }

  protected function getAccessUri()
  {
    $er_id = $this->action->getEResource()->getId();

    $this->action->getUser()->setFlash('er_id', $er_id );

    if ( $this->isOnsite ) {
      return $this->action->er->getAccessInfo()->getOnsiteAccessUri();
    }
    else {
      return $this->action->er->getAccessInfo()->getOffsiteAccessUri();
    }
  }

  static public function factory( sfAction $action )
  {
    if ( $action->getUser()->getOnsiteLibraryId() ) {
      $class = $action->er->getAccessInfo()->getOnsiteAccessHandler();
    }
    else {
      $class = $action->er->getAccessInfo()->getOffsiteAccessHandler();
    }

    if ( class_exists( $class ) ) {
      return new $class( $action );
    }
    else {
      $msg = 'Unknown access handler class';
      throw new UnexpectedValueException( $msg );
    }
  }

  static public function loadClasses()
  {
    $directory = dirname(__FILE__);

    if ( ! is_dir( $directory ) ) {
      throw new UnexpectedValueException( 'Not a directory' );
    }

    $dir_obj = dir( $directory );

    while ( ( $entry = $dir_obj->read() ) !== false ) {
      if (
        $entry != 'BaseAccessHandler.class.php'
        && substr( $entry, -23 ) == 'AccessHandler.class.php'
      ) {
        require_once( $directory . '/' . $entry );
      }
    }

    unset( $dir_obj );

    $directory = $directory . '/script';

    if ( is_dir( $directory ) && is_readable( $directory ) ) {
      $dir_obj = dir( $directory );

      while ( ( $entry = $dir_obj->read() ) !== false ) {
        if (
          $entry != 'BaseAccessHandler.class.php'
          && substr( $entry, -23 ) == 'AccessHandler.class.php'
        ) {
          require_once( $directory . '/' . $entry );
        }
      }

      unset( $dir_obj );
    }
  }
}
