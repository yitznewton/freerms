<?php

/**
 * Library filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseLibraryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'alt_name'           => new sfWidgetFormFilterInput(),
      'address'            => new sfWidgetFormFilterInput(),
      'ezproxy_host'       => new sfWidgetFormFilterInput(),
      'ezproxy_key'        => new sfWidgetFormFilterInput(),
      'cost_center_no'     => new sfWidgetFormFilterInput(),
      'fte'                => new sfWidgetFormFilterInput(),
      'note'               => new sfWidgetFormFilterInput(),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'acq_lib_assoc_list' => new sfWidgetFormPropelChoice(array('model' => 'Acquisition', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'code'               => new sfValidatorPass(array('required' => false)),
      'alt_name'           => new sfValidatorPass(array('required' => false)),
      'address'            => new sfValidatorPass(array('required' => false)),
      'ezproxy_host'       => new sfValidatorPass(array('required' => false)),
      'ezproxy_key'        => new sfValidatorPass(array('required' => false)),
      'cost_center_no'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fte'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'note'               => new sfValidatorPass(array('required' => false)),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'acq_lib_assoc_list' => new sfValidatorPropelChoice(array('model' => 'Acquisition', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('library_filters[%s]');

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

    $criteria->addJoin(AcqLibAssocPeer::LIB_ID, LibraryPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AcqLibAssocPeer::ACQ_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AcqLibAssocPeer::ACQ_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Library';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'code'               => 'Text',
      'alt_name'           => 'Text',
      'address'            => 'Text',
      'ezproxy_host'       => 'Text',
      'ezproxy_key'        => 'Text',
      'cost_center_no'     => 'Number',
      'fte'                => 'Number',
      'note'               => 'Text',
      'updated_at'         => 'Date',
      'acq_lib_assoc_list' => 'ManyKey',
    );
  }
}
