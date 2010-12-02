<?php

class UnavailableAccessHandler extends BaseAccessHandler
{
  public function execute()
  {
    $this->action->getUser()->setFlash('title', $this->action->er->getTitle());
    
    $this->action->redirect('database/authmethodUnavailable');

    return;
  }
}
