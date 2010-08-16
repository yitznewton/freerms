<?php

/**
 * EResourceDbSubjectAssoc filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEResourceDbSubjectAssocFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('e_resource_db_subject_assoc_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EResourceDbSubjectAssoc';
  }

  public function getFields()
  {
    return array(
      'er_id'         => 'ForeignKey',
      'db_subject_id' => 'ForeignKey',
    );
  }
}
