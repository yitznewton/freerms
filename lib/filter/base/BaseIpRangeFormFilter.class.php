<?php

/**
 * IpRange filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseIpRangeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'lib_id'                         => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => true)),
      'start_ip'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'end_ip'                         => new sfWidgetFormFilterInput(),
      'active_indicator'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'proxy_indicator'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'note'                           => new sfWidgetFormFilterInput(),
      'updated_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'auto_email_ip_reg_event_list'   => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'manual_email_ip_reg_event_list' => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'lib_id'                         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Library', 'column' => 'id')),
      'start_ip'                       => new sfValidatorPass(array('required' => false)),
      'end_ip'                         => new sfValidatorPass(array('required' => false)),
      'active_indicator'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'proxy_indicator'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'note'                           => new sfValidatorPass(array('required' => false)),
      'updated_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auto_email_ip_reg_event_list'   => new sfValidatorPropelChoice(array('model' => 'Contact', 'required' => false)),
      'manual_email_ip_reg_event_list' => new sfValidatorPropelChoice(array('model' => 'Contact', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ip_range_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAutoEmailIpRegEventListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AutoEmailIpRegEventPeer::IP_RANGE_ID, IpRangePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AutoEmailIpRegEventPeer::CONTACT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AutoEmailIpRegEventPeer::CONTACT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addManualEmailIpRegEventListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ManualEmailIpRegEventPeer::IP_RANGE_ID, IpRangePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ManualEmailIpRegEventPeer::CONTACT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ManualEmailIpRegEventPeer::CONTACT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'IpRange';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'lib_id'                         => 'ForeignKey',
      'start_ip'                       => 'Text',
      'end_ip'                         => 'Text',
      'active_indicator'               => 'Boolean',
      'proxy_indicator'                => 'Boolean',
      'note'                           => 'Text',
      'updated_at'                     => 'Date',
      'deleted_at'                     => 'Date',
      'auto_email_ip_reg_event_list'   => 'ManyKey',
      'manual_email_ip_reg_event_list' => 'ManyKey',
    );
  }
}
