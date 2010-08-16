<?php

/**
 * AdminInfo form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AdminInfoForm extends BaseAdminInfoForm
{
  public function configure()
  {
    unset($this['deleted_at']);

    $this->widgetSchema['ui_config_available']->setLabel('UI configurable');
    $this->widgetSchema['subscriber_branding_available']
      ->setLabel('Subscriber branding');
    $this->widgetSchema['personalized_features_available']
      ->setLabel('Personalization');
    $this->widgetSchema['inbound_linking_available']
      ->setLabel('Inbound linking');
    $this->widgetSchema['open_url_compliance_available']
      ->setLabel('OpenURL compliant');
    $this->widgetSchema['marc_records_available']
      ->setLabel('MARC records');
    $this->widgetSchema['marc_record_note']
      ->setLabel('MARC record note');
    $this->widgetSchema['ss_360_search_available']
      ->setLabel('360 Search Connection');
    $this->widgetSchema['usage_stats_delivery_id']
      ->setLabel('Usage stats delivery via');
    $this->widgetSchema['usage_stats_format_id']
      ->setLabel('Usage stats format');
    $this->widgetSchema['usage_stats_freq_id']
      ->setLabel('Usage stats frequency');
    $this->widgetSchema['usage_stats_uri']
      ->setLabel('Usage stats URI');
    $this->widgetSchema['system_status_uri']
      ->setLabel('System status URI');
    $this->widgetSchema['admin_doc_uri']
      ->setLabel('Admin doc URI');
    $this->widgetSchema['user_doc_uri']
      ->setLabel('User doc URI');

    $org = OrganizationPeer::retrieveByEResource($this->getObject()->getId());

    if ($org){

      if ($org->getUsageStatsUri()){
        $this->widgetSchema['usage_stats_uri']
          = new freermsWidgetFormInputDisplay(array(
          'indicator' => 'Vendor-level',
          'text' => $org->getUsageStatsUri()
        ));
      }
      if ($org->getUsageStatsUsername()){
        $this->widgetSchema['usage_stats_username']
          = new freermsWidgetFormInputDisplay(array(
          'indicator' => 'Vendor-level',
          'text' => $org->getUsageStatsUsername()
        ));
      }
      if ($org->getUsageStatsPassword()){
        $this->widgetSchema['usage_stats_password']
          = new freermsWidgetFormInputDisplay(array(
          'indicator' => 'Vendor-level',
          'text' => $org->getUsageStatsPassword()
        ));
      }
    }

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');
  }
}
