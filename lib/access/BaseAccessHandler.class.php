<?php

class BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Open or IP-based';

  protected $action;
  protected $er;
  protected $isOnsite;

  protected function __construct( sfAction $action, EResource $er )
  {
    $this->action   = $action;
    $this->er       = $er;
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

  static public function factory( sfAction $action, EResource $er )
  {
    if ( $action->getUser()->getOnsiteLibraryId() ) {
      $class = $er->getAccessInfo()->getOnsiteAccessHandler();
    }
    else {
      $class = $er->getAccessInfo()->getOffsiteAccessHandler();
    }

    if ( class_exists( $class ) ) {
      return new $class( $action, $er );
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

    $directory = $directory . '/custom';

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
  
  static public function getOnsiteHandlers()
  {
    BaseAccessHandler::loadClasses();

    $classes = array();

    foreach ( get_declared_classes() as $class_name ) {
      if (
        substr( $class_name, -13 ) == 'AccessHandler'
        && substr( $class_name, 0, 10 ) != 'AccessInfo'
        && $class_name::IS_VALID_ONSITE
      ) {
        $classes[ $class_name ] = $class_name::DESCRIPTION;
      }
    }

    natcasesort( $classes );
    
    return $classes;
  }

  static public function getOffsiteHandlers()
  {
    BaseAccessHandler::loadClasses();

    $classes = array();

    foreach ( get_declared_classes() as $class_name ) {
      if (
        substr( $class_name, -13 ) == 'AccessHandler'
        && substr( $class_name, 0, 10 ) != 'AccessInfo'
        && $class_name::IS_VALID_OFFSITE
      ) {
        $classes[ $class_name ] = $class_name::DESCRIPTION;
      }
    }

    natcasesort( $classes );
    
    return $classes;
  }
}
