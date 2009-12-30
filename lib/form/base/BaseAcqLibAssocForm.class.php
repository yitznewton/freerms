<?php

/**
 * AcqLibAssoc form base class.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAcqLibAssocForm extends BaseFormPropel
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
