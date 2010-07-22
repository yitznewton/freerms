<?php

/**
 * Acquisition filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAcquisitionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'note'               => new sfWidgetFormFilterInput(),
      'vendor_org_id'      => new sfWidgetFormPropelChoice(array('model' => 'Organization', 'add_empty' => true)),
      'deleted_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'acq_lib_assoc_list' => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'note'               => new sfValidatorPass(array('required' => false)),
      'vendor_org_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Organization', 'column' => 'id')),
      'deleted_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'acq_lib_assoc_list' => new sfValidatorPropelChoice(array('model' => 'Library', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('acquisition_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAcqLibAssocListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AcqLibAssocPeer::ACQ_ID, AcquisitionPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AcqLibAssocPeer::LIB_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AcqLibAssocPeer::LIB_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Acquisition';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'note'               => 'Text',
      'vendor_org_id'      => 'ForeignKey',
      'deleted_at'         => 'Date',
      'acq_lib_assoc_list' => 'ManyKey',
    );
  }
}
