<?php

/**
 * IpRegMethod form base class.
 *
 * @method IpRegMethod getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseIpRegMethodForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'label' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'label' => new sfValidatorString(array('max_length' => 25)),
    ));

    $this->widgetSchema->setNameFormat('ip_reg_method[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRegMethod';
  }


}
