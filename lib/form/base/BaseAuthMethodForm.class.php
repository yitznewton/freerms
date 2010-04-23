<?php

/**
 * AuthMethod form base class.
 *
 * @method AuthMethod getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAuthMethodForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'label'            => new sfWidgetFormInputText(),
      'is_valid_onsite'  => new sfWidgetFormInputCheckbox(),
      'is_valid_offsite' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'AuthMethod', 'column' => 'id', 'required' => false)),
      'label'            => new sfValidatorString(array('max_length' => 50)),
      'is_valid_onsite'  => new sfValidatorBoolean(),
      'is_valid_offsite' => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('auth_method[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthMethod';
  }


}
