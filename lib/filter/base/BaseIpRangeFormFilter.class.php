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
      'lib_id'           => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => true)),
      'start_ip'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'start_ip_int'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'end_ip'           => new sfWidgetFormFilterInput(),
      'end_ip_int'       => new sfWidgetFormFilterInput(),
      'active_indicator' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'proxy_indicator'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'note'             => new sfWidgetFormFilterInput(),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'lib_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Library', 'column' => 'id')),
      'start_ip'         => new sfValidatorPass(array('required' => false)),
      'start_ip_int'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'end_ip'           => new sfValidatorPass(array('required' => false)),
      'end_ip_int'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active_indicator' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'proxy_indicator'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'note'             => new sfValidatorPass(array('required' => false)),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('ip_range_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRange';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'lib_id'           => 'ForeignKey',
      'start_ip'         => 'Text',
      'start_ip_int'     => 'Number',
      'end_ip'           => 'Text',
      'end_ip_int'       => 'Number',
      'active_indicator' => 'Boolean',
      'proxy_indicator'  => 'Boolean',
      'note'             => 'Text',
      'updated_at'       => 'Date',
      'deleted_at'       => 'Date',
    );
  }
}
