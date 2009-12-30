<?php

/**
 * DbSubject filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDbSubjectFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'label'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'                             => new sfWidgetFormFilterInput(),
      'e_resource_db_subject_assoc_list' => new sfWidgetFormPropelChoice(array('model' => 'EResource', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'label'                            => new sfValidatorPass(array('required' => false)),
      'slug'                             => new sfValidatorPass(array('required' => false)),
      'e_resource_db_subject_assoc_list' => new sfValidatorPropelChoice(array('model' => 'EResource', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('db_subject_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addEResourceDbSubjectAssocListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, DbSubjectPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EResourceDbSubjectAssocPeer::ER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EResourceDbSubjectAssocPeer::ER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'DbSubject';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'label'                            => 'Text',
      'slug'                             => 'Text',
      'e_resource_db_subject_assoc_list' => 'ManyKey',
    );
  }
}
