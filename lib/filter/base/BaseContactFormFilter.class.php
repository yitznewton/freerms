<?php

/**
 * Contact filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseContactFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'last_name'                      => new sfWidgetFormFilterInput(),
      'first_name'                     => new sfWidgetFormFilterInput(),
      'title'                          => new sfWidgetFormFilterInput(),
      'role'                           => new sfWidgetFormFilterInput(),
      'address'                        => new sfWidgetFormFilterInput(),
      'email'                          => new sfWidgetFormFilterInput(),
      'phone'                          => new sfWidgetFormFilterInput(),
      'fax'                            => new sfWidgetFormFilterInput(),
      'note'                           => new sfWidgetFormFilterInput(),
      'org_id'                         => new sfWidgetFormPropelChoice(array('model' => 'Organization', 'add_empty' => true)),
      'updated_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'auto_email_ip_reg_event_list'   => new sfWidgetFormPropelChoice(array('model' => 'IpRange', 'add_empty' => true)),
      'manual_email_ip_reg_event_list' => new sfWidgetFormPropelChoice(array('model' => 'IpRange', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'last_name'                      => new sfValidatorPass(array('required' => false)),
      'first_name'                     => new sfValidatorPass(array('required' => false)),
      'title'                          => new sfValidatorPass(array('required' => false)),
      'role'                           => new sfValidatorPass(array('required' => false)),
      'address'                        => new sfValidatorPass(array('required' => false)),
      'email'                          => new sfValidatorPass(array('required' => false)),
      'phone'                          => new sfValidatorPass(array('required' => false)),
      'fax'                            => new sfValidatorPass(array('required' => false)),
      'note'                           => new sfValidatorPass(array('required' => false)),
      'org_id'                         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Organization', 'column' => 'id')),
      'updated_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auto_email_ip_reg_event_list'   => new sfValidatorPropelChoice(array('model' => 'IpRange', 'required' => false)),
      'manual_email_ip_reg_event_list' => new sfValidatorPropelChoice(array('model' => 'IpRange', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact_filters[%s]');

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

    $criteria->addJoin(AutoEmailIpRegEventPeer::CONTACT_ID, ContactPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AutoEmailIpRegEventPeer::IP_RANGE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AutoEmailIpRegEventPeer::IP_RANGE_ID, $value));
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

    $criteria->addJoin(ManualEmailIpRegEventPeer::CONTACT_ID, ContactPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ManualEmailIpRegEventPeer::IP_RANGE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ManualEmailIpRegEventPeer::IP_RANGE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Contact';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'last_name'                      => 'Text',
      'first_name'                     => 'Text',
      'title'                          => 'Text',
      'role'                           => 'Text',
      'address'                        => 'Text',
      'email'                          => 'Text',
      'phone'                          => 'Text',
      'fax'                            => 'Text',
      'note'                           => 'Text',
      'org_id'                         => 'ForeignKey',
      'updated_at'                     => 'Date',
      'auto_email_ip_reg_event_list'   => 'ManyKey',
      'manual_email_ip_reg_event_list' => 'ManyKey',
    );
  }
}
