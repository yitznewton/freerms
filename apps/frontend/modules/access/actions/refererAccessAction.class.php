<?php
require_once __DIR__.'/baseAccessAction.class.php';

class refererAccessAction extends baseAccessAction
{
  const IS_VALID_ONSITE   = false;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'Referer URL';

  public function execute($request)
  {
    $user = $this->getUser();

    if (!$user->hasFlash('database_url')) {
      // user linked directly to refer dummy page
      $this->redirect('@homepage');
    }

    if (!$this->isSubscribed()) {
      throw new accessUnauthorizedException();
    }

    $this->databaseTitle = $user->getFlash('database_title');
    $this->databaseUrl   = $user->getFlash('database_url');
    $this->referralNote  = $user->getFlash('referral_note');

    return sfView::SUCCESS;
  }
}

