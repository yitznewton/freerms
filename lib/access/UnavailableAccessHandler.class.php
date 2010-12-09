<?php

class UnavailableAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Unavailable';

  public function execute()
  {
    $this->action->getUser()->setFlash('title', $this->action->er->getTitle());
    $this->action->forward('database', 'unavailableHandler');

    return;
  }
}
