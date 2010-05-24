<?php

/**
 * Organization filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseOrganizationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'alt_name'                => new sfWidgetFormFilterInput(),
      'account_number'          => new sfWidgetFormFilterInput(),
      'address'                 => new sfWidgetFormFilterInput(),
      'phone'                   => new sfWidgetFormFilterInput(),
      'fax'                     => new sfWidgetFormFilterInput(),
      'notice_address_licensor' => new sfWidgetFormFilterInput(),
      'ip_reg_method_id'        => new sfWidgetFormPropelChoice(array('model' => 'IpRegMethod', 'add_empty' => true)),
      'ip_reg_uri'              => new sfWidgetFormFilterInput(),
      'ip_reg_username'         => new sfWidgetFormFilterInput(),
      'ip_reg_password'         => new sfWidgetFormFilterInput(),
      'ip_reg_contact_id'       => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'note'                    => new sfWidgetFormFilterInput(),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'                    => new sfValidatorPass(array('required' => false)),
      'alt_name'                => new sfValidatorPass(array('required' => false)),
      'account_number'          => new sfValidatorPass(array('required' => false)),
      'address'                 => new sfValidatorPass(array('required' => false)),
      'phone'                   => new sfValidatorPass(array('required' => false)),
      'fax'                     => new sfValidatorPass(array('required' => false)),
      'notice_address_licensor' => new sfValidatorPass(array('required' => false)),
      'ip_reg_method_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'IpRegMethod', 'column' => 'id')),
      'ip_reg_uri'              => new sfValidatorPass(array('required' => false)),
      'ip_reg_username'         => new sfValidatorPass(array('required' => false)),
      'ip_reg_password'         => new sfValidatorPass(array('required' => false)),
      'ip_reg_contact_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Contact', 'column' => 'id')),
      'note'                    => new sfValidatorPass(array('required' => false)),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('organization_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Organization';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'name'                    => 'Text',
      'alt_name'                => 'Text',
      'account_number'          => 'Text',
      'address'                 => 'Text',
      'phone'                   => 'Text',
      'fax'                     => 'Text',
      'notice_address_licensor' => 'Text',
      'ip_reg_method_id'        => 'ForeignKey',
      'ip_reg_uri'              => 'Text',
      'ip_reg_username'         => 'Text',
      'ip_reg_password'         => 'Text',
      'ip_reg_contact_id'       => 'ForeignKey',
      'note'                    => 'Text',
      'updated_at'              => 'Date',
    );
  }
}
