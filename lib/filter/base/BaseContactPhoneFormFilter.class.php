<?php

/**
 * ContactPhone filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseContactPhoneFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'number'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'contact_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Contact', 'column' => 'id')),
      'number'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact_phone_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactPhone';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'contact_id' => 'ForeignKey',
      'number'     => 'Text',
    );
  }
}
