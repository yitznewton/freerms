<?php

/**
 * IpRegEvent filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseIpRegEventFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_range_id'  => new sfWidgetFormPropelChoice(array('model' => 'IpRange', 'add_empty' => true)),
      'acq_id'       => new sfWidgetFormPropelChoice(array('model' => 'Acquisition', 'add_empty' => true)),
      'old_start_ip' => new sfWidgetFormFilterInput(),
      'old_end_ip'   => new sfWidgetFormFilterInput(),
      'new_start_ip' => new sfWidgetFormFilterInput(),
      'new_end_ip'   => new sfWidgetFormFilterInput(),
      'processed'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'ip_range_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'IpRange', 'column' => 'id')),
      'acq_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Acquisition', 'column' => 'id')),
      'old_start_ip' => new sfValidatorPass(array('required' => false)),
      'old_end_ip'   => new sfValidatorPass(array('required' => false)),
      'new_start_ip' => new sfValidatorPass(array('required' => false)),
      'new_end_ip'   => new sfValidatorPass(array('required' => false)),
      'processed'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('ip_reg_event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRegEvent';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'ip_range_id'  => 'ForeignKey',
      'acq_id'       => 'ForeignKey',
      'old_start_ip' => 'Text',
      'old_end_ip'   => 'Text',
      'new_start_ip' => 'Text',
      'new_end_ip'   => 'Text',
      'processed'    => 'Boolean',
      'updated_at'   => 'Date',
    );
  }
}
