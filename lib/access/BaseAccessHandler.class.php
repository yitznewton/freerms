<?php

class BaseAccessHandler
{
  protected $action;

  public function execute()
  {
    if ( $action->getUser()->getOnsiteLibraryId() ) {
      $method = 'getOnsiteAccessUri';
    }
    else {
      $method = 'getOffsiteAccessUri';
    }

    $this->action->redirect( $this->action->er->getAccessInfo()->$method() );

    return;
  }

  protected function __construct( sfAction $action )
  {
    $this->action = $action;
  }

  static public function factory( sfAction $action )
  {
    if ( $action->getUser()->getOnsiteLibraryId() ) {
      $auth_id = $action->er->getAccessInfo()->getOnsiteAuthMethodId();
    }
    else {
      $auth_id = $action->er->getAccessInfo()->getOffsiteAuthMethodId();
    }

    $auth = AuthMethodPeer::retrieveByPK($auth_id);

    switch ( $auth->getLabel() ) {
      case 'Script':
      case 'IP + Script':
        return ScriptAccessHandler::factory( $action );
      case 'Referer URL':
        return new RefererAccessHandler( $action );
      case 'Unavailable':
        return new UnavailableAccessHandler( $action );
      default:
        return new BaseAccessHandler( $action );
    }
  }
}