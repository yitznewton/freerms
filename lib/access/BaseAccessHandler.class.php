<?php

class BaseAccessHander
{
  protected $action;

  public function execute()
  {
    // redirect directly to access URI
  }

  protected function __construct( sfAction $action )
  {
    $this->action = $action;
  }

  public function factory( sfAction $action )
  {
    if ($action->getUser()->getOnsiteLibraryId()) {
      $method = 'getOnsiteAuthMethod';
    }
    else {
      $method = 'getOffsiteAuthMethod';
    }
    
    switch ($action->er->getAccessInfo()->$method()) {
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