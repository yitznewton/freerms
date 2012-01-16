<?php
require_once __DIR__.'/ezproxyAccessAction.class.php';

class ezproxyUrlAccessAction extends ezproxyAccessAction
{
  const IS_VALID_ONSITE   = false;
  const IS_VALID_OFFSITE  = false;
  const DESCRIPTION       = '';

  public function execute($request)
  {
    $raw_url = $request->getUri();
    $url     = substr( $raw_url, strrpos($raw_url, '/url/') + 5 );

    $this->forward404Unless(substr($url, 0, 4) == 'http');

    if ($this->getContext()->getAffiliation()->isOnsite()) {
      $this->redirect($url);
    }

    $this->forceLogin();

    $library_ids = $this->getContext()->getAffiliation()->getLibraryIds();

    // TODO: somehow intelligently guess which Library to use?
    $library = Doctrine_Core::getTable('Library')
      ->find($library_ids[0]);

    $this->redirectToEZproxy($url, $library);
  }
}

