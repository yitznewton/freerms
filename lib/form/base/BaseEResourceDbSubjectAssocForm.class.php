<?php

/**
 * EResourceDbSubjectAssoc form base class.
 *
 * @method EResourceDbSubjectAssoc getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseEResourceDbSubjectAssocForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'er_id'         => new sfWidgetFormInputHidden(),
      'db_subject_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'er_id'         => new sfValidatorPropelChoice(array('model' => 'EResource', 'column' => 'id', 'required' => false)),
      'db_subject_id' => new sfValidatorPropelChoice(array('model' => 'DbSubject', 'column' => 'id', 'required' => false)),
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
