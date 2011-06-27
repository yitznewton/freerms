<?php

class EResourceFeaturedForm extends BaseEResourceForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'featured_weight' => new sfWidgetFormInputText(array(
        'label' => 'Weight for ' . $this->getObject()->getTitle(),
      )),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'featured_weight' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));
    
    $this->widgetSchema->setNameFormat('e_resource[%s]');
    $this->widgetSchema->setLabel( false );
    $this->widgetSchema->setAttribute('class', 'EResourceDbSubjectAssocForm');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    BaseFormPropel::setup();
  }
}
