<?php

class baseAccessAction extends sfAction
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const IS_CUSTOM         = false;
  const DESCRIPTION       = 'IP-based';

  /**
   * @param sfWebRequest $request
   */
  public function execute($request)
  {
    if (!$this->isSubscribed()) {
      $this->forward403();
    }

    $this->logUsageAndRedirect($this->getUser()->getFlash('database_url'));
  }

  /**
   * @param string $destination
   */
  protected function logUsageAndRedirect($destination)
  {
    $this->logUsage();
    $this->redirect($destination);
  }

  protected function logUsage()
  {
    $affiliation     = $this->context->getAffiliation();
    $libraryIds      = $affiliation->getLibraryIds();
    $userDataService = UserDataService::factory($this->getUser());

    $usage = new DatabaseUsage();
    $usage->setDatabaseId($this->getUser()->getFlash('database_id'));
    $usage->setSessionid(substr(session_id(), 0, 8));
    $usage->setLibraryId($libraryIds[0]);
    $usage->setIsOnsite($affiliation->isOnsite());
    $usage->setIsMobile($this->request->isMobile());
    $usage->setTimestamp(gmdate('Y-m-d\TH:i:s'));
    $usage->setAdditionalData($userDataService->get());

    $usage->log();
  }

  protected function forceLogin()
  {
    if (!$this->getUser()->isAuthenticated()) {
      $this->forward(sfConfig::get('sf_login_module'),
        sfConfig::get('sf_login_action'));
    }
  }
  
  protected function forward403()
  {
    $this->forward(sfConfig::get('sf_secure_module'),
      sfConfig::get('sf_secure_action'));
  }

  /**
   * Whether user is affiliated with a Library which subscribes to the
   * requested Database
   *
   * @return bool
   */
  protected function isSubscribed()
  {
    if (!$this->getUserDatabaseLibraryIds()) {
      return false;
    }

    $databaseAccessControl = $this->getUser()
      ->getFlash('database_access_control');

    if (!$databaseAccessControl) {
      return true;
    }

    if ($this->context->getAffiliation()->isOnsite()) {
      $this->getUser()->addCredential('onsite');
    }

    return $this->getUser()->hasCredential($databaseAccessControl);
  }

  /**
   * Returns an array of IDs of all Libraries shared by the user and the
   * database
   *
   * @return array int[]
   */
  protected function getUserDatabaseLibraryIds()
  {
    // FIXME the onsite access control test bug passes through here;
    // flash attribute missing one of two IDs
    return array_values(array_intersect(
      $this->getContext()->getAffiliation()->getLibraryIds(),
      $this->getUser()->getFlash('database_library_ids', array())
    ));
  }
}

