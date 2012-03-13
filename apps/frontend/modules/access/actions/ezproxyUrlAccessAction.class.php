<?php
require_once __DIR__.'/ezproxyAccessAction.class.php';

class ezproxyUrlAccessAction extends ezproxyAccessAction
{
  const IS_VALID_ONSITE   = false;
  const IS_VALID_OFFSITE  = false;
  const DESCRIPTION       = '';

  public function execute($request)
  {
    $this->forward404Unless($this->getUrl());

    if ($this->getContext()->getAffiliation()->isOnsite()) {
      $this->redirect($this->getUrl());
    }

    $this->forceLogin();

    $library_ids = $this->getContext()->getAffiliation()->getLibraryIds();

    // TODO: somehow intelligently guess which Library to use?
    $library = Doctrine_Core::getTable('Library')
      ->find($library_ids[0]);

    $this->logUsage();

    $this->redirectToEZproxy($this->getUrl(), $library);
  }

  /**
   * Returns the URL requested for proxy by the user
   *
   * @return string
   */
  protected function getUrl()
  {
    $raw_url = $this->getRequest()->getUri();

    if (strpos($raw_url, '/url/') !== false) {
      $url = substr($raw_url, strrpos($raw_url, '/url/') + 5);
    }
    elseif (strpos($raw_url, '/direct-refer/') !== false) {
      $url = substr($raw_url, strrpos($raw_url, '/direct-refer/') + 14);
    }
    else {
      return null;
    }

    if (substr($url, 0, 4) == 'http') {
      return $url;
    }
    else {
      return null;
    }
  }

  protected function logUsage()
  {
    $affiliation     = $this->context->getAffiliation();
    $libraryIds      = $affiliation->getLibraryIds();
    $userDataService = UserDataService::factory($this->getUser());

    $host = parse_url($this->getUrl(), PHP_URL_HOST);

    if (!$host) {
      $host = null;
    }

    $usage = new UrlUsage();
    $usage->setSessionid(substr(session_id(), 0, 8));
    $usage->setHost($host);
    $usage->setLibraryId($libraryIds[0]);
    $usage->setIsOnsite($affiliation->isOnsite());
    $usage->setTimestamp(gmdate('Y-m-d\TH:i:s'));
    $usage->setAdditionalData($userDataService->get());

    $usage->log();
  }
}

