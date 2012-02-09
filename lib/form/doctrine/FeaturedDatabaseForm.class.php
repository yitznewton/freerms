<?php

class FeaturedDatabaseForm extends BaseDatabaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
      'featured_weight' => new sfWidgetFormInputText(array(
        'label' => $this->getObject()->getTitle(),
      ), array(
        'class' => 'weight',
      )),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'featured_weight' => new sfValidatorInteger(),
    ));

    $this->widgetSchema['id']->setAttribute('class', 'database-id');
    $this->widgetSchema['featured_weight']->setDefault('999');

    $this->widgetSchema->setNameFormat('database[%s]');
    $this->widgetSchema->setLabel(false);

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    BaseFormDoctrine::setup();
  }
}

