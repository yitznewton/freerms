<?php

/**
 * ManualEmailIpRegEvent form base class.
 *
 * @method ManualEmailIpRegEvent getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseManualEmailIpRegEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_range_id'  => new sfWidgetFormInputHidden(),
      'old_start_ip' => new sfWidgetFormInputText(),
      'old_end_ip'   => new sfWidgetFormInputText(),
      'new_start_ip' => new sfWidgetFormInputText(),
      'new_end_ip'   => new sfWidgetFormInputText(),
      'contact_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'ip_range_id'  => new sfValidatorPropelChoice(array('model' => 'IpRange', 'column' => 'id', 'required' => false)),
      'old_start_ip' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'old_end_ip'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'new_start_ip' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'new_end_ip'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'contact_id'   => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('manual_email_ip_reg_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ManualEmailIpRegEvent';
  }


}
