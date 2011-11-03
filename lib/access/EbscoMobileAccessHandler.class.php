<?php

class EbscoMobileAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'EBSCO mobile-enabled';
  const FORCE_AUTH_ONSITE = false;

  protected $isMobile;
  
  public function execute( sfAction $action )
  {
    if ( $this->isOnsite ) {
      return BaseAccessHandler::execute( $action );
    }
    else {
      return RefererAccessHandler::execute( $action );
    }
  }
  
  protected function getAccessUri()
  {
    if ( $this->isOnsite ) {
      $url = $this->er->getAccessInfo()->getOnsiteAccessUri();
    }
    else {
      $url = $this->er->getAccessInfo()->getOffsiteAccessUri();
    }
    
    if ( $this->isMobile() ) {
      return preg_replace( '/profile=[A-Za-z0-9]+/', 'profile=mobile', $url );
    }
    
    return parent::getAccessUri();
  }
  
  /**
   *
   * @return bool
   */
  protected function isMobile()
  {
    $detect = new MobileDetect();
    return $detect->isMobile();
  }
  
  /**
   *
   * @param string $agent 
   * @return bool
   */
  protected function isAgentMobile( $agent )
  {
    $detect = new MobileDetect();
    var_dump($detect->isIphone('Mozilla/5.0 (iPod; U; iPhone OS 2_0 like Mac OS X; en-us) AppleWebKit/525.17 (KHTML, like Gecko) Version/3.1 Mobile/5A240d Safari/5525.7'));exit;
  }
}
