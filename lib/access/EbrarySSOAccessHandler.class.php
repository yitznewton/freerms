<?php

class EbrarySSOAccessHandler extends EZproxyAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION      = 'ebrary SSO';
  
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
