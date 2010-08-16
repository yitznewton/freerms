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
      'id'           => new sfWidgetFormInputHidden(),
      'ip_range_id'  => new sfWidgetFormPropelChoice(array('model' => 'IpRange', 'add_empty' => false)),
      'acq_id'       => new sfWidgetFormPropelChoice(array('model' => 'Acquisition', 'add_empty' => false)),
      'old_start_ip' => new sfWidgetFormInputText(),
      'old_end_ip'   => new sfWidgetFormInputText(),
      'new_start_ip' => new sfWidgetFormInputText(),
      'new_end_ip'   => new sfWidgetFormInputText(),
      'processed'    => new sfWidgetFormInputCheckbox(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'ip_range_id'  => new sfValidatorPropelChoice(array('model' => 'IpRange', 'column' => 'id')),
      'acq_id'       => new sfValidatorPropelChoice(array('model' => 'Acquisition', 'column' => 'id')),
      'old_start_ip' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'old_end_ip'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'new_start_ip' => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'new_end_ip'   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'processed'    => new sfValidatorBoolean(),
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
