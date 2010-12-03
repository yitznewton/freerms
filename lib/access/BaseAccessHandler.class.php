<?php

class BaseAccessHandler
{
  protected $action;

  protected function __construct( sfAction $action )
  {
    $this->action = $action;
  }

  public function execute()
  {
    if ( $action->getUser()->getOnsiteLibraryId() ) {
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

    if ( $this->action->getUser()->getOnsiteLibraryId() ) {
      return $this->action->er->getAccessInfo()->getOnsiteAccessUri();
    }
    else {
      return $this->action->er->getAccessInfo()->getOffsiteAccessUri();
    }
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