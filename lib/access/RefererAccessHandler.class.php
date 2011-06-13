<?php

class RefererAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = false;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'Referer URL';

  public function execute()
  {
    $this->checkAffiliation();
    
    if ( ! $this->getAccessUri() ) {
      $this->action->redirect( sfConfig::get('app_homepage-redirect-url') );
      return;
    }
    
    $this->action->getUser()->setFlash(
      'er_title', $this->er->getTitle() );
    
    $this->action->getUser()->setFlash(
      'er_referral_note', $this->er->getAccessInfo()->getReferralNote() );
    
    $this->action->getUser()->setFlash(
      'er_access_uri', $this->getAccessUri() );
    
    $this->action->redirect('database/refer');

    return;
  }
}
