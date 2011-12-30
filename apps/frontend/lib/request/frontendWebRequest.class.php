<?php
class frontendWebRequest extends sfWebRequest
{
  /**
   * Whether the user has requested to force login on campus
   *
   * @return bool
   */
  public function isForceLogin()
  {
    // needs to be namespaced for sfGuardPlugin to cleanup on logout
    if (
      $this->getContext()->getUser()
        ->getAttribute('force-login', null, 'sfGuardSecurityUser')
    ) {
      return $this->isForceLogin = true;
    }

    $value = $this->hasParameter('login');

    $this->getContext()->getUser()->setAttribute('force-login',
      $value, 'sfGuardSecurityUser');

    return $value;
  }
}

