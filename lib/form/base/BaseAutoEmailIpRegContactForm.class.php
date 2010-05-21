<?php

/**
 * AutoEmailIpRegContact form base class.
 *
 * @method AutoEmailIpRegContact getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAutoEmailIpRegContactForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'last_name'  => new sfWidgetFormInputText(),
      'first_name' => new sfWidgetFormInputText(),
      'email'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'AutoEmailIpRegContact', 'column' => 'id', 'required' => false)),
      'last_name'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'first_name' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('auto_email_ip_reg_contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AutoEmailIpRegContact';
  }


}
