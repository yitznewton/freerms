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

    $this->title         = $user->getFlash('database_title');
    $this->database_url  = $user->getFlash('database_url');
    $this->referral_note = $user->getFlash('referral_note');

    if ($this->referral_note) {
      $this->getResponse()->addMeta('Refresh',
        '0;url=' . $this->database_url);
    }

    return sfView::SUCCESS;
  }
}

