<?php

/**
 * ContactEmail form base class.
 *
 * @method ContactEmail getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseContactEmailForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => false)),
      'address'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'contact_id' => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id')),
      'address'    => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('contact_email[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactEmail';
  }


}
