<?php

/**
 * AutoEmailIpRegEvent filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAutoEmailIpRegEventFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'old_start_ip' => new sfWidgetFormFilterInput(),
      'old_end_ip'   => new sfWidgetFormFilterInput(),
      'new_start_ip' => new sfWidgetFormFilterInput(),
      'new_end_ip'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'old_start_ip' => new sfValidatorPass(array('required' => false)),
      'old_end_ip'   => new sfValidatorPass(array('required' => false)),
      'new_start_ip' => new sfValidatorPass(array('required' => false)),
      'new_end_ip'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('auto_email_ip_reg_event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AutoEmailIpRegEvent';
  }

  public function getFields()
  {
    return array(
      'ip_range_id'  => 'ForeignKey',
      'old_start_ip' => 'Text',
      'old_end_ip'   => 'Text',
      'new_start_ip' => 'Text',
      'new_end_ip'   => 'Text',
      'contact_id'   => 'ForeignKey',
    );
  }
}
