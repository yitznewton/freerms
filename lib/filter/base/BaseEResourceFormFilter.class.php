<?php

/**
 * EResource filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEResourceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'alt_id'                           => new sfWidgetFormFilterInput(),
      'subscription_number'              => new sfWidgetFormFilterInput(),
      'title'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_title'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'alt_title'                        => new sfWidgetFormFilterInput(),
      'language'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'                      => new sfWidgetFormFilterInput(),
      'public_note'                      => new sfWidgetFormFilterInput(),
      'suppression'                      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'product_unavailable'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'acq_id'                           => new sfWidgetFormPropelChoice(array('model' => 'Acquisition', 'add_empty' => true)),
      'access_info_id'                   => new sfWidgetFormPropelChoice(array('model' => 'AccessInfo', 'add_empty' => true)),
      'admin_info_id'                    => new sfWidgetFormPropelChoice(array('model' => 'AdminInfo', 'add_empty' => true)),
      'created_at'                       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'                       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'e_resource_db_subject_assoc_list' => new sfWidgetFormPropelChoice(array('model' => 'DbSubject', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'alt_id'                           => new sfValidatorPass(array('required' => false)),
      'subscription_number'              => new sfValidatorPass(array('required' => false)),
      'title'                            => new sfValidatorPass(array('required' => false)),
      'sort_title'                       => new sfValidatorPass(array('required' => false)),
      'alt_title'                        => new sfValidatorPass(array('required' => false)),
      'language'                         => new sfValidatorPass(array('required' => false)),
      'description'                      => new sfValidatorPass(array('required' => false)),
      'public_note'                      => new sfValidatorPass(array('required' => false)),
      'suppression'                      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'product_unavailable'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'acq_id'                           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Acquisition', 'column' => 'id')),
      'access_info_id'                   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AccessInfo', 'column' => 'id')),
      'admin_info_id'                    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AdminInfo', 'column' => 'id')),
      'created_at'                       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'                       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'e_resource_db_subject_assoc_list' => new sfValidatorPropelChoice(array('model' => 'DbSubject', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('e_resource_filters[%s]');

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

    $criteria->addJoin(EResourceDbSubjectAssocPeer::ER_ID, EResourcePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'EResource';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'alt_id'                           => 'Text',
      'subscription_number'              => 'Text',
      'title'                            => 'Text',
      'sort_title'                       => 'Text',
      'alt_title'                        => 'Text',
      'language'                         => 'Text',
      'description'                      => 'Text',
      'public_note'                      => 'Text',
      'suppression'                      => 'Boolean',
      'product_unavailable'              => 'Boolean',
      'acq_id'                           => 'ForeignKey',
      'access_info_id'                   => 'ForeignKey',
      'admin_info_id'                    => 'ForeignKey',
      'created_at'                       => 'Date',
      'updated_at'                       => 'Date',
      'deleted_at'                       => 'Date',
      'e_resource_db_subject_assoc_list' => 'ManyKey',
    );
  }
}
