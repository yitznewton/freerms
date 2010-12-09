<?php

class RefererAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = false;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Referer URL';

  public function execute()
  {
    $this->action->getUser()->setFlash('er_id', $this->action->er->getId() );
    $this->action->getUser()->setFlash('access_uri', $this->getAccessUri() );
    $this->action->redirect('database/refer');

    return;
  }
}
