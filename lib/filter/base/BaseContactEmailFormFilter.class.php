<?php

/**
 * ContactEmail filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseContactEmailFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'address'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'contact_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Contact', 'column' => 'id')),
      'address'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact_email_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactEmail';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'contact_id' => 'ForeignKey',
      'address'    => 'Text',
    );
  }
}
