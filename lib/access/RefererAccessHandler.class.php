<?php

class RefererAccessHandler extends BaseAccessHandler
{
  public function execute()
  {
    $this->action->getUser()->setFlash('er_id', $this->action->er->getId() );

    if ( $this->action->getUser()->getOnsiteLibraryId() ) {
      $method = 'getOnsiteAccessUri';
    }
    else {
      $method = 'getOffsiteAccessUri';
    }

    $access_uri = $this->action->er->getAccessInfo()->$method();

    $this->action->getUser()->setFlash('access_uri', $access_uri);
           
    $this->action->redirect('database/refer');

    return;
  }
}
