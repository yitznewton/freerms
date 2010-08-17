<?php

/**
 * IpRange form base class.
 *
 * @method IpRange getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseIpRangeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'lib_id'           => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => false)),
      'start_ip'         => new sfWidgetFormInputText(),
      'start_ip_int'     => new sfWidgetFormInputText(),
      'end_ip'           => new sfWidgetFormInputText(),
      'end_ip_int'       => new sfWidgetFormInputText(),
      'active_indicator' => new sfWidgetFormInputCheckbox(),
      'proxy_indicator'  => new sfWidgetFormInputCheckbox(),
      'note'             => new sfWidgetFormInputText(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'lib_id'           => new sfValidatorPropelChoice(array('model' => 'Library', 'column' => 'id')),
      'start_ip'         => new sfValidatorString(array('max_length' => 15)),
      'start_ip_int'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'end_ip'           => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'end_ip_int'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'active_indicator' => new sfValidatorBoolean(),
      'proxy_indicator'  => new sfValidatorBoolean(),
      'note'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at'       => new sfValidatorDateTime(),
      'deleted_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ip_range[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRange';
  }


}
