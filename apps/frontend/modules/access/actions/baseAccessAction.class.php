<?php

class baseAccessAction extends sfAction
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'IP-based';

  /**
   * @param sfWebRequest $request
   */
  public function execute($request)
  {
    if (!$this->isSubscribed()) {
      throw new accessUnauthorizedException();
    }

    $this->redirect($this->getUser()->getFlash('database_url'));
  }

  public function postExecute()
  {
    // FIXME make sure this is only called once after all forwards and
    // redirects are handled
    // FIXME alter this for ezproxyUrlAccess
    $affiliation     = $this->context->getAffiliation();
    $libraryIds      = $affiliation->getLibraryIds();
    $userDataService = UserDataService::factory($this->getUser());

    $usage = new DatabaseUsage();
    $usage->setDatabaseId($this->getUser()->getFlash('database_id'));
    $usage->setSessionid(substr(session_id(), 0, 8));
    $usage->setLibraryId($libraryIds[0]);
    $usage->setIsOnsite($affiliation->isOnsite());
    $usage->setTimestamp(date());
    $usage->setUserData($userDataService->toJson());

    $usage->save();
  }

  protected function forceLogin()
  {
    if (!$this->getUser()->isAuthenticated()) {
      $this->forward(sfConfig::get('sf_login_module'),
        sfConfig::get('sf_login_action') );
    }
  }

  /**
   * Whether user is affiliated with a Library which subscribes to the
   * requested Database
   *
   * @return bool
   */
  protected function isSubscribed()
  {
    return (bool) $this->getUserDatabaseLibraryIds();
  }

  /**
   * Returns an array of IDs of all Libraries shared by the user and the
   * database
   *
   * @return array int[]
   */
  protected function getUserDatabaseLibraryIds()
  {
    return array_values(array_intersect(
      $this->getContext()->getAffiliation()->getLibraryIds(),
      $this->getUser()->getFlash('database_library_ids')
    ));
  }
}

