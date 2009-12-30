<?php

/**
 * AccessInfo form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AccessInfoForm extends BaseAccessInfoForm
{
  public function configure()
  {
    unset($this['deleted_at']);
    
    $this->widgetSchema['onsite_auth_method_id']
      ->setLabel('Onsite authentication via');
    $this->widgetSchema['offsite_auth_method_id']
      ->setLabel('Offsite authentication via');
    $this->widgetSchema['ezproxy_cfg_entry']
      ->setLabel('ezproxy.cfg entry');
    $this->widgetSchema['referral_note']
      ->setLabel('User note on referral');
      
    // filter AuthMethods by on-/off-site validity
    
    $cOn = new Criteria();
    $cOn->add(AuthMethodPeer::IS_VALID_ONSITE, 1);
    
    $this->widgetSchema['onsite_auth_method_id']
      ->setOption('criteria', $cOn);
      
    $cOff = new Criteria();
    $cOff->add(AuthMethodPeer::IS_VALID_OFFSITE, 1);

    $this->widgetSchema['offsite_auth_method_id']
      ->setOption('criteria', $cOff);
      
    $onsite_auth_label = sfConfig::get('app_access_onsite-auth-default');
    $offsite_auth_label = sfConfig::get('app_access_offsite-auth-default');
    
    // set AuthMethod defaults based on app.yml
    
    if ($onsite_auth_method
      = AuthMethodPeer::retrieveByLabel($onsite_auth_label)) {
      $this->setDefault(
        'onsite_auth_method_id',
        $onsite_auth_method->getId()
      );
    }

    if ($offsite_auth_method
      = AuthMethodPeer::retrieveByLabel($offsite_auth_label)) {
      $this->setDefault(
        'offsite_auth_method_id',
        $offsite_auth_method->getId()
      );
    }
    
    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');
  }
}
