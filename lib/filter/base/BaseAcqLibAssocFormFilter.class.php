<?php

/**
 * AcqLibAssoc filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAcqLibAssocFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('acq_lib_assoc_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AcqLibAssoc';
  }

  public function getFields()
  {
    return array(
      'lib_id' => 'ForeignKey',
      'acq_id' => 'ForeignKey',
    );
  }
}
