<?php

class EbrarySSOAccessHandler extends EZproxyAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'ebrary SSO';
  
  public function execute()
  {
    if (
      strpos( 'site.ebrary.com', $_SERVER['HTTP_REFERER'] ) !== false
      && ! $this->action->getUser()->isAuthenticated()
    ) {
      $this->action->forward(
        sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action') );

      return;
    }
    
    return parent::execute();
  }
  
  protected function getAccessUri()
  {
    $ebrary_site = sfConfig::get('app_ebrary-site');
    
    if ( ! is_string( $ebrary_site ) ) {
      throw new UnexpectedValueException('ebrary site not set in config');
    }

    return 'http://' . $this->getLibrary()->getEZProxyHost()
           . '/ebrary/' . $ebrary_site . '/unauthorized';
  }
}
