<?php

/**
 * EResourceDbSubjectAssoc form base class.
 *
 * @method EResourceDbSubjectAssoc getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEResourceDbSubjectAssocForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'er_id'           => new sfWidgetFormInputHidden(),
      'db_subject_id'   => new sfWidgetFormInputHidden(),
      'featured_weight' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'er_id'           => new sfValidatorPropelChoice(array('model' => 'EResource', 'column' => 'id', 'required' => false)),
      'db_subject_id'   => new sfValidatorPropelChoice(array('model' => 'DbSubject', 'column' => 'id', 'required' => false)),
      'featured_weight' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('e_resource_db_subject_assoc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EResourceDbSubjectAssoc';
  }


}
