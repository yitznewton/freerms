<?php
require_once __DIR__.'/ezproxyAccessAction.class.php';

class ebrarySSOAccessAction extends ezproxyAccessAction
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const IS_CUSTOM         = true;
  const DESCRIPTION       = 'ebrary SSO';

  public function execute($request)
  {
    if (!$this->isSubscribed()) {
      $this->forward403();
    }

    if ($request->hasParameter('signin')) {
      $this->forceLogin();
    }

    if ($this->getUser()->isAuthenticated()) {
      $library_ids = $this->getUserDatabaseLibraryIds();

      $library = Doctrine_Core::getTable('Library')
        ->find($library_ids[0]);

      $this->redirectToEZproxy($this->mungeUrl($this->getUser()
        ->getFlash('database_url'), $library),
        $library);
    }

    $this->logUsageAndRedirect($this->getUser()->getFlash('database_url'));
  }

  protected function mungeUrl($url, Library $library)
  {
    preg_match('`[^/]+$`', $url, $site_matches);

    return 'http://' . $library->getEzproxyHost() . '/ebrary/'
           . $site_matches[0] . '/unauthorized';
  }
}

