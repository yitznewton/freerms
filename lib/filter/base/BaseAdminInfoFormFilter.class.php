<?php

/**
 * AdminInfo filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAdminInfoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ui_config_available'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'subscriber_branding_available'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'subscriber_branding_note'         => new sfWidgetFormFilterInput(),
      'personalized_features_available'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'inbound_linking_available'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'open_url_compliance_available'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'linking_note'                     => new sfWidgetFormFilterInput(),
      'marc_records_available'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'marc_record_note'                 => new sfWidgetFormFilterInput(),
      'ss_360_search_available'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usage_stats_available'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'usage_stats_standards_compliance' => new sfWidgetFormFilterInput(),
      'usage_stats_delivery_id'          => new sfWidgetFormPropelChoice(array('model' => 'InfoExchangeMethod', 'add_empty' => true)),
      'usage_stats_format_id'            => new sfWidgetFormPropelChoice(array('model' => 'UsageStatsFormat', 'add_empty' => true)),
      'usage_stats_freq_id'              => new sfWidgetFormPropelChoice(array('model' => 'UsageStatsFreq', 'add_empty' => true)),
      'usage_stats_uri'                  => new sfWidgetFormFilterInput(),
      'usage_stats_username'             => new sfWidgetFormFilterInput(),
      'usage_stats_password'             => new sfWidgetFormFilterInput(),
      'usage_stats_note'                 => new sfWidgetFormFilterInput(),
      'software_requirements'            => new sfWidgetFormFilterInput(),
      'system_status_uri'                => new sfWidgetFormFilterInput(),
      'product_advisory_note'            => new sfWidgetFormFilterInput(),
      'training_info'                    => new sfWidgetFormFilterInput(),
      'admin_doc_uri'                    => new sfWidgetFormFilterInput(),
      'user_doc_uri'                     => new sfWidgetFormFilterInput(),
      'note'                             => new sfWidgetFormFilterInput(),
      'deleted_at'                       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'ui_config_available'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'subscriber_branding_available'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'subscriber_branding_note'         => new sfValidatorPass(array('required' => false)),
      'personalized_features_available'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'inbound_linking_available'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'open_url_compliance_available'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'linking_note'                     => new sfValidatorPass(array('required' => false)),
      'marc_records_available'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'marc_record_note'                 => new sfValidatorPass(array('required' => false)),
      'ss_360_search_available'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usage_stats_available'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'usage_stats_standards_compliance' => new sfValidatorPass(array('required' => false)),
      'usage_stats_delivery_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'InfoExchangeMethod', 'column' => 'id')),
      'usage_stats_format_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'UsageStatsFormat', 'column' => 'id')),
      'usage_stats_freq_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'UsageStatsFreq', 'column' => 'id')),
      'usage_stats_uri'                  => new sfValidatorPass(array('required' => false)),
      'usage_stats_username'             => new sfValidatorPass(array('required' => false)),
      'usage_stats_password'             => new sfValidatorPass(array('required' => false)),
      'usage_stats_note'                 => new sfValidatorPass(array('required' => false)),
      'software_requirements'            => new sfValidatorPass(array('required' => false)),
      'system_status_uri'                => new sfValidatorPass(array('required' => false)),
      'product_advisory_note'            => new sfValidatorPass(array('required' => false)),
      'training_info'                    => new sfValidatorPass(array('required' => false)),
      'admin_doc_uri'                    => new sfValidatorPass(array('required' => false)),
      'user_doc_uri'                     => new sfValidatorPass(array('required' => false)),
      'note'                             => new sfValidatorPass(array('required' => false)),
      'deleted_at'                       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('admin_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdminInfo';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'ui_config_available'              => 'Boolean',
      'subscriber_branding_available'    => 'Boolean',
      'subscriber_branding_note'         => 'Text',
      'personalized_features_available'  => 'Boolean',
      'inbound_linking_available'        => 'Boolean',
      'open_url_compliance_available'    => 'Boolean',
      'linking_note'                     => 'Text',
      'marc_records_available'           => 'Boolean',
      'marc_record_note'                 => 'Text',
      'ss_360_search_available'          => 'Boolean',
      'usage_stats_available'            => 'Boolean',
      'usage_stats_standards_compliance' => 'Text',
      'usage_stats_delivery_id'          => 'ForeignKey',
      'usage_stats_format_id'            => 'ForeignKey',
      'usage_stats_freq_id'              => 'ForeignKey',
      'usage_stats_uri'                  => 'Text',
      'usage_stats_username'             => 'Text',
      'usage_stats_password'             => 'Text',
      'usage_stats_note'                 => 'Text',
      'software_requirements'            => 'Text',
      'system_status_uri'                => 'Text',
      'product_advisory_note'            => 'Text',
      'training_info'                    => 'Text',
      'admin_doc_uri'                    => 'Text',
      'user_doc_uri'                     => 'Text',
      'note'                             => 'Text',
      'deleted_at'                       => 'Date',
    );
  }
}
