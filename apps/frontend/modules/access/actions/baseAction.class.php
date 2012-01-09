<?php

class baseAction extends sfAction
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'IP-based';
  const FORCE_AUTH_ONSITE = false;

  /**
   * @param sfWebRequest $request
   */
  public function execute($request)
  {
    if (!$this->isSubscriber()) {
      throw new accessUnauthorizedException();
    }

    if (static::FORCE_AUTH_ONSITE && !$this->getUser()->isAuthenticated()) {
      $this->forward(sfConfig::get('sf_login_module'),
        sfConfig::get('sf_login_action') );
    }

    $this->redirect($this->getUser()->getFlash('database_url'));
  }

  /**
   * Whether user is affiliated with a Library which subscribes to the
   * requested Database
   *
   * @return bool
   */
  protected function isSubscriber()
  {
    if (!array_intersect(
      $this->getContext()->getAffiliation()->getLibraryIds(),
      $this->getUser()->getFlash('database_library_ids')
    )) {
      return false;
    }
    else {
      return true;
    }
  }
}

