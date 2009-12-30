<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Acquisition filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAcquisitionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'note'               => new sfWidgetFormFilterInput(),
      'acq_lib_assoc_list' => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'note'               => new sfValidatorPass(array('required' => false)),
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
      'acq_lib_assoc_list' => 'ManyKey',
    );
  }
}
