<?php

/**
 * AuthMethod form base class.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAuthMethodForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'label'            => new sfWidgetFormInput(),
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
