<?php

/**
 * ContactPhone form base class.
 *
 * @method ContactPhone getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseContactPhoneForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => false)),
      'number'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'ContactPhone', 'column' => 'id', 'required' => false)),
      'contact_id' => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id')),
      'number'     => new sfValidatorString(array('max_length' => 40)),
    ));

    $this->widgetSchema->setNameFormat('contact_phone[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactPhone';
  }


}
