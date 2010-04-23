<?php

/**
 * AdminInfo form base class.
 *
 * @method AdminInfo getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAdminInfoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'ui_config_available'              => new sfWidgetFormInputCheckbox(),
      'subscriber_branding_available'    => new sfWidgetFormInputCheckbox(),
      'subscriber_branding_note'         => new sfWidgetFormTextarea(),
      'personalized_features_available'  => new sfWidgetFormInputCheckbox(),
      'inbound_linking_available'        => new sfWidgetFormInputCheckbox(),
      'open_url_compliance_available'    => new sfWidgetFormInputCheckbox(),
      'linking_note'                     => new sfWidgetFormTextarea(),
      'marc_records_available'           => new sfWidgetFormInputCheckbox(),
      'marc_record_note'                 => new sfWidgetFormTextarea(),
      'ss_360_search_available'          => new sfWidgetFormInputCheckbox(),
      'usage_stats_available'            => new sfWidgetFormInputCheckbox(),
      'usage_stats_standards_compliance' => new sfWidgetFormInputText(),
      'usage_stats_delivery_id'          => new sfWidgetFormPropelChoice(array('model' => 'InfoExchangeMethod', 'add_empty' => true)),
      'usage_stats_format_id'            => new sfWidgetFormPropelChoice(array('model' => 'UsageStatsFormat', 'add_empty' => true)),
      'usage_stats_freq_id'              => new sfWidgetFormPropelChoice(array('model' => 'UsageStatsFreq', 'add_empty' => true)),
      'usage_stats_uri'                  => new sfWidgetFormInputText(),
      'usage_stats_username'             => new sfWidgetFormInputText(),
      'usage_stats_password'             => new sfWidgetFormInputText(),
      'usage_stats_note'                 => new sfWidgetFormTextarea(),
      'software_requirements'            => new sfWidgetFormTextarea(),
      'system_status_uri'                => new sfWidgetFormInputText(),
      'product_advisory_note'            => new sfWidgetFormTextarea(),
      'training_info'                    => new sfWidgetFormTextarea(),
      'admin_doc_uri'                    => new sfWidgetFormInputText(),
      'user_doc_uri'                     => new sfWidgetFormInputText(),
      'note'                             => new sfWidgetFormTextarea(),
      'deleted_at'                       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AdminInfo', 'column' => 'id', 'required' => false)),
      'ui_config_available'              => new sfValidatorBoolean(array('required' => false)),
      'subscriber_branding_available'    => new sfValidatorBoolean(array('required' => false)),
      'subscriber_branding_note'         => new sfValidatorString(array('required' => false)),
      'personalized_features_available'  => new sfValidatorBoolean(array('required' => false)),
      'inbound_linking_available'        => new sfValidatorBoolean(array('required' => false)),
      'open_url_compliance_available'    => new sfValidatorBoolean(array('required' => false)),
      'linking_note'                     => new sfValidatorString(array('required' => false)),
      'marc_records_available'           => new sfValidatorBoolean(array('required' => false)),
      'marc_record_note'                 => new sfValidatorString(array('required' => false)),
      'ss_360_search_available'          => new sfValidatorBoolean(array('required' => false)),
      'usage_stats_available'            => new sfValidatorBoolean(array('required' => false)),
      'usage_stats_standards_compliance' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usage_stats_delivery_id'          => new sfValidatorPropelChoice(array('model' => 'InfoExchangeMethod', 'column' => 'id', 'required' => false)),
      'usage_stats_format_id'            => new sfValidatorPropelChoice(array('model' => 'UsageStatsFormat', 'column' => 'id', 'required' => false)),
      'usage_stats_freq_id'              => new sfValidatorPropelChoice(array('model' => 'UsageStatsFreq', 'column' => 'id', 'required' => false)),
      'usage_stats_uri'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'usage_stats_username'             => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'usage_stats_password'             => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'usage_stats_note'                 => new sfValidatorString(array('required' => false)),
      'software_requirements'            => new sfValidatorString(array('required' => false)),
      'system_status_uri'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'product_advisory_note'            => new sfValidatorString(array('required' => false)),
      'training_info'                    => new sfValidatorString(array('required' => false)),
      'admin_doc_uri'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_doc_uri'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'note'                             => new sfValidatorString(array('required' => false)),
      'deleted_at'                       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('admin_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdminInfo';
  }


}
