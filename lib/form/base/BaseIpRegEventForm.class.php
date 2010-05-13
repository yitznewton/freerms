<?php

/**
 * IpRegEvent form base class.
 *
 * @method IpRegEvent getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseIpRegEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_range_id'  => new sfWidgetFormInputHidden(),
      'old_start_ip' => new sfWidgetFormInputText(),
      'old_end_ip'   => new sfWidgetFormInputText(),
      'new_start_ip' => new sfWidgetFormInputText(),
      'new_end_ip'   => new sfWidgetFormInputText(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'ip_range_id'  => new sfValidatorPropelChoice(array('model' => 'IpRange', 'column' => 'id', 'required' => false)),
      'old_start_ip' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'old_end_ip'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'new_start_ip' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'new_end_ip'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ip_reg_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRegEvent';
  }


}
