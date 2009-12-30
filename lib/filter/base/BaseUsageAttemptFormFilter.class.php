<?php

/**
 * UsageAttempt filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseUsageAttemptFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'er_id'                => new sfWidgetFormPropelChoice(array('model' => 'EResource', 'add_empty' => true)),
      'lib_id'               => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => true)),
      'phpsessid'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ip'                   => new sfWidgetFormFilterInput(),
      'date'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'auth_successful'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'additional_user_data' => new sfWidgetFormFilterInput(),
      'note'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'er_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EResource', 'column' => 'id')),
      'lib_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Library', 'column' => 'id')),
      'phpsessid'            => new sfValidatorPass(array('required' => false)),
      'ip'                   => new sfValidatorPass(array('required' => false)),
      'date'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auth_successful'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'additional_user_data' => new sfValidatorPass(array('required' => false)),
      'note'                 => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usage_attempt_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAttempt';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'er_id'                => 'ForeignKey',
      'lib_id'               => 'ForeignKey',
      'phpsessid'            => 'Text',
      'ip'                   => 'Text',
      'date'                 => 'Date',
      'auth_successful'      => 'Boolean',
      'additional_user_data' => 'Text',
      'note'                 => 'Text',
    );
  }
}
