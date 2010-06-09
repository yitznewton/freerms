<?php

/**
 * UsageAttempt form base class.
 *
 * @method UsageAttempt getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUsageAttemptForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'er_id'                => new sfWidgetFormPropelChoice(array('model' => 'EResource', 'add_empty' => false)),
      'lib_id'               => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => true)),
      'phpsessid'            => new sfWidgetFormInputText(),
      'ip'                   => new sfWidgetFormInputText(),
      'date'                 => new sfWidgetFormDateTime(),
      'auth_successful'      => new sfWidgetFormInputCheckbox(),
      'additional_user_data' => new sfWidgetFormInputText(),
      'note'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'er_id'                => new sfValidatorPropelChoice(array('model' => 'EResource', 'column' => 'id')),
      'lib_id'               => new sfValidatorPropelChoice(array('model' => 'Library', 'column' => 'id', 'required' => false)),
      'phpsessid'            => new sfValidatorString(array('max_length' => 32)),
      'ip'                   => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'date'                 => new sfValidatorDateTime(),
      'auth_successful'      => new sfValidatorBoolean(),
      'additional_user_data' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'note'                 => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('usage_attempt[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAttempt';
  }


}
