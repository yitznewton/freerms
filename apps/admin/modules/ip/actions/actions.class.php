<?php

require_once dirname(__FILE__).'/../lib/ipGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ipGeneratorHelper.class.php';

/**
 * ip actions.
 *
 * @package    freerms
 * @subpackage ip
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ipActions extends autoIpActions
{
  public function executeRegistration(sfWebRequest $request)
  {
    $this->auto_email   = IpRegEventPeer::retrieveAutoEmail();
    $this->manual_email = IpRegEventPeer::retrieveManualEmailArray();
    $this->phone        = IpRegEventPeer::retrievePhoneArray();
    $this->web_contact  = IpRegEventPeer::retrieveWebContactFormArray();
    $this->web_admin = false;
  }
  
  public function executeAutoregister(sfWebRequest $request)
  {

  }
  
}
