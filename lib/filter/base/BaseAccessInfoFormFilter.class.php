<?php

/**
 * AccessInfo filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAccessInfoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'onsite_access_uri'      => new sfWidgetFormFilterInput(),
      'offsite_access_uri'     => new sfWidgetFormFilterInput(),
      'onsite_access_handler'  => new sfWidgetFormFilterInput(),
      'offsite_access_handler' => new sfWidgetFormFilterInput(),
      'access_username'        => new sfWidgetFormFilterInput(),
      'access_password'        => new sfWidgetFormFilterInput(),
      'access_password_note'   => new sfWidgetFormFilterInput(),
      'concurrent_users'       => new sfWidgetFormFilterInput(),
      'ezproxy_cfg_entry'      => new sfWidgetFormFilterInput(),
      'referral_note'          => new sfWidgetFormFilterInput(),
      'note'                   => new sfWidgetFormFilterInput(),
      'deleted_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'onsite_access_uri'      => new sfValidatorPass(array('required' => false)),
      'offsite_access_uri'     => new sfValidatorPass(array('required' => false)),
      'onsite_access_handler'  => new sfValidatorPass(array('required' => false)),
      'offsite_access_handler' => new sfValidatorPass(array('required' => false)),
      'access_username'        => new sfValidatorPass(array('required' => false)),
      'access_password'        => new sfValidatorPass(array('required' => false)),
      'access_password_note'   => new sfValidatorPass(array('required' => false)),
      'concurrent_users'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ezproxy_cfg_entry'      => new sfValidatorPass(array('required' => false)),
      'referral_note'          => new sfValidatorPass(array('required' => false)),
      'note'                   => new sfValidatorPass(array('required' => false)),
      'deleted_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('access_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccessInfo';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'onsite_access_uri'      => 'Text',
      'offsite_access_uri'     => 'Text',
      'onsite_access_handler'  => 'Text',
      'offsite_access_handler' => 'Text',
      'access_username'        => 'Text',
      'access_password'        => 'Text',
      'access_password_note'   => 'Text',
      'concurrent_users'       => 'Number',
      'ezproxy_cfg_entry'      => 'Text',
      'referral_note'          => 'Text',
      'note'                   => 'Text',
      'deleted_at'             => 'Date',
    );
  }
}
