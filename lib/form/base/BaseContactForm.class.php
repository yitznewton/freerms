<?php

/**
 * Contact form base class.
 *
 * @method Contact getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseContactForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'last_name'  => new sfWidgetFormInputText(),
      'first_name' => new sfWidgetFormInputText(),
      'title'      => new sfWidgetFormInputText(),
      'role'       => new sfWidgetFormInputText(),
      'address'    => new sfWidgetFormTextarea(),
      'email'      => new sfWidgetFormInputText(),
      'fax'        => new sfWidgetFormInputText(),
      'note'       => new sfWidgetFormTextarea(),
      'org_id'     => new sfWidgetFormPropelChoice(array('model' => 'Organization', 'add_empty' => true)),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id', 'required' => false)),
      'last_name'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'first_name' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'title'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'role'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'    => new sfValidatorString(array('required' => false)),
      'email'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'fax'        => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'note'       => new sfValidatorString(array('required' => false)),
      'org_id'     => new sfValidatorPropelChoice(array('model' => 'Organization', 'column' => 'id', 'required' => false)),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact';
  }


}
