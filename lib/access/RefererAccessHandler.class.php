<?php

class RefererAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = false;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Referer URL';

  public function execute( sfAction $action )
  {
    $this->checkAffiliation();
    
    if ( ! $this->getAccessUri() ) {
      $this->action->redirect( sfConfig::get('app_homepage-redirect-url') );
      return;
    }
    
    $action->getUser()->setFlash(
      'er_title', $this->er->getTitle() );
    
    $action->getUser()->setFlash(
      'er_referral_note', $this->er->getAccessInfo()->getReferralNote() );
    
    $action->getUser()->setFlash(
      'er_access_uri', $this->getAccessUri() );
    
    $action->redirect('database/refer');

    return;
  }
}
