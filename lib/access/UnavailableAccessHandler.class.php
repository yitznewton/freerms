<?php

class UnavailableAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Unavailable';

  public function execute( sfAction $action )
  {
    $action->getUser()->setFlash('title', $this->er->getTitle());
    $action->forward('database', 'unavailableHandler');

    return;
  }
}
