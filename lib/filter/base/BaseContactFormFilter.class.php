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
      'last_name'  => new sfWidgetFormFilterInput(),
      'first_name' => new sfWidgetFormFilterInput(),
      'title'      => new sfWidgetFormFilterInput(),
      'role'       => new sfWidgetFormFilterInput(),
      'address'    => new sfWidgetFormFilterInput(),
      'email'      => new sfWidgetFormFilterInput(),
      'fax'        => new sfWidgetFormFilterInput(),
      'note'       => new sfWidgetFormFilterInput(),
      'org_id'     => new sfWidgetFormPropelChoice(array('model' => 'Organization', 'add_empty' => true)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'last_name'  => new sfValidatorPass(array('required' => false)),
      'first_name' => new sfValidatorPass(array('required' => false)),
      'title'      => new sfValidatorPass(array('required' => false)),
      'role'       => new sfValidatorPass(array('required' => false)),
      'address'    => new sfValidatorPass(array('required' => false)),
      'email'      => new sfValidatorPass(array('required' => false)),
      'fax'        => new sfValidatorPass(array('required' => false)),
      'note'       => new sfValidatorPass(array('required' => false)),
      'org_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Organization', 'column' => 'id')),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('contact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'last_name'  => 'Text',
      'first_name' => 'Text',
      'title'      => 'Text',
      'role'       => 'Text',
      'address'    => 'Text',
      'email'      => 'Text',
      'fax'        => 'Text',
      'note'       => 'Text',
      'org_id'     => 'ForeignKey',
      'updated_at' => 'Date',
    );
  }
}
