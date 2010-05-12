<?php

/**
 * Organization form base class.
 *
 * @method Organization getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseOrganizationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'name'                    => new sfWidgetFormInputText(),
      'alt_name'                => new sfWidgetFormInputText(),
      'account_number'          => new sfWidgetFormInputText(),
      'address'                 => new sfWidgetFormTextarea(),
      'phone'                   => new sfWidgetFormInputText(),
      'fax'                     => new sfWidgetFormInputText(),
      'notice_address_licensor' => new sfWidgetFormTextarea(),
      'ip_reg_method_id'        => new sfWidgetFormPropelChoice(array('model' => 'IpRegMethod', 'add_empty' => true)),
      'ip_reg_uri'              => new sfWidgetFormInputText(),
      'ip_reg_username'         => new sfWidgetFormInputText(),
      'ip_reg_password'         => new sfWidgetFormInputText(),
      'ip_reg_contact_id'       => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'ip_reg_force_manual'     => new sfWidgetFormInputCheckbox(),
      'note'                    => new sfWidgetFormTextarea(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'Organization', 'column' => 'id', 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 255)),
      'alt_name'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'account_number'          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'address'                 => new sfValidatorString(array('required' => false)),
      'phone'                   => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'fax'                     => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'notice_address_licensor' => new sfValidatorString(array('required' => false)),
      'ip_reg_method_id'        => new sfValidatorPropelChoice(array('model' => 'IpRegMethod', 'column' => 'id', 'required' => false)),
      'ip_reg_uri'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ip_reg_username'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'ip_reg_password'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'ip_reg_contact_id'       => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id', 'required' => false)),
      'ip_reg_force_manual'     => new sfValidatorBoolean(array('required' => false)),
      'note'                    => new sfValidatorString(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('organization[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Organization';
  }


}
