<?php

/**
 * AcqLibAssoc form base class.
 *
 * @method AcqLibAssoc getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAcqLibAssocForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'lib_id' => new sfWidgetFormInputHidden(),
      'acq_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'lib_id' => new sfValidatorPropelChoice(array('model' => 'Library', 'column' => 'id', 'required' => false)),
      'acq_id' => new sfValidatorPropelChoice(array('model' => 'Acquisition', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('acq_lib_assoc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AcqLibAssoc';
  }


}
