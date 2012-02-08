<?php

class FeaturedDatabaseForm extends BaseDatabaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
      'featured_weight' => new sfWidgetFormInputText(array(
        'label' => $this->getObject()->getTitle(),
      )),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'featured_weight' => new sfValidatorInteger(),
    ));

    $this->widgetSchema['featured_weight']->setDefault('0');

    $this->widgetSchema->setNameFormat('database[%s]');
    $this->widgetSchema->setLabel(false);

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    BaseFormDoctrine::setup();
  }
}

