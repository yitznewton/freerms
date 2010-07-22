<?php

/**
 * OrgType form base class.
 *
 * @method OrgType getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseOrgTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'label' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'label' => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('org_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrgType';
  }


}
