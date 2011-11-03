<?php

class BaseAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'Open or IP-based';
  const FORCE_AUTH_ONSITE = false;

  protected $er;
  protected $affiliation;
  protected $isOnsite;

  protected function __construct( EResource $er,
    freermsUserAffiliation $affiliation, $is_onsite )
  {
    $this->er          = $er;
    $this->affiliation = $affiliation;
    $this->isOnsite    = $is_onsite;
  }

  public function execute( sfAction $action )
  {
    $this->checkAffiliation();
    
    $class_name = get_class( $this );
    
    if (
      $class_name::FORCE_AUTH_ONSITE
      && ! $action->getUser()->isAuthenticated()
    ) {
      $action->forward(
        sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action') );

      return;
    }
    
    $action->redirect( $this->getAccessUri() );

    return;
  }

  protected function getAccessUri()
  {
    if ( $this->isOnsite ) {
      return $this->er->getAccessInfo()->getOnsiteAccessUri();
    }
    else {
      return $this->er->getAccessInfo()->getOffsiteAccessUri();
    }
  }
  
  protected function checkAffiliation()
  {
    if ( ! array_intersect(
      $this->affiliation->get(), $this->er->getLibraryIds()
    )) {
      throw new freermsUnauthorizedException();
    }
  }

  /**
   * @param EResource $er
   * @param freermsUserAffiliation $affiliation
   * @return BaseAccessHandler
   */
  static public function factory( EResource $er,
    freermsUserAffiliation $affiliation )
  {
    $is_onsite = $affiliation->isOnsite();
    
    if ( $is_onsite ) {
      $class = $er->getAccessInfo()->getOnsiteAccessHandler();
    }
    else {
      $class = $er->getAccessInfo()->getOffsiteAccessHandler();
    }

    if ( class_exists( $class ) ) {
      return new $class( $er, $affiliation, $is_onsite );
    }
    else {
      $msg = 'Unknown access handler class';
      throw new MissingAccessHandlerException( $msg );
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

    if ( is_dir( $directory ) && is_readable( $directory )) {
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
