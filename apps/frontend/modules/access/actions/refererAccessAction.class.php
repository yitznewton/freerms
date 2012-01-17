<?php
require_once __DIR__.'/baseAccessAction.class.php';

class refererAccessAction extends baseAccessAction
{
  const IS_VALID_ONSITE   = false;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'Referer URL';

  public function execute($request)
  {
    if (!$this->isSubscribed()) {
      throw new accessUnauthorizedException();
    }

    $user = $this->getUser();

    $this->databaseTitle = $user->getFlash('database_title');
    $this->databaseUrl   = $user->getFlash('database_url');
    $this->referralNote  = $user->getFlash('referral_note');

    if (!$this->referralNote) {
      $this->getResponse()->addHttpMeta('Refresh',
        '0;url=' . $this->databaseUrl);
    }

    return sfView::SUCCESS;
  }
}

