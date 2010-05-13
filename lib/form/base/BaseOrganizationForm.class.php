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
      'id'                           => new sfWidgetFormInputHidden(),
      'name'                         => new sfWidgetFormInputText(),
      'alt_name'                     => new sfWidgetFormInputText(),
      'org_type_id'                  => new sfWidgetFormPropelChoice(array('model' => 'OrgType', 'add_empty' => true)),
      'account_number'               => new sfWidgetFormInputText(),
      'address'                      => new sfWidgetFormTextarea(),
      'phone'                        => new sfWidgetFormInputText(),
      'fax'                          => new sfWidgetFormInputText(),
      'notice_address_licensor'      => new sfWidgetFormTextarea(),
      'ip_notification_method_id'    => new sfWidgetFormPropelChoice(array('model' => 'IpNotificationMethod', 'add_empty' => true)),
      'ip_notification_uri'          => new sfWidgetFormInputText(),
      'ip_notification_username'     => new sfWidgetFormInputText(),
      'ip_notification_password'     => new sfWidgetFormInputText(),
      'ip_notification_contact_id'   => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'ip_notification_force_manual' => new sfWidgetFormInputCheckbox(),
      'note'                         => new sfWidgetFormTextarea(),
      'updated_at'                   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorPropelChoice(array('model' => 'Organization', 'column' => 'id', 'required' => false)),
      'name'                         => new sfValidatorString(array('max_length' => 255)),
      'alt_name'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'org_type_id'                  => new sfValidatorPropelChoice(array('model' => 'OrgType', 'column' => 'id', 'required' => false)),
      'account_number'               => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'address'                      => new sfValidatorString(array('required' => false)),
      'phone'                        => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'fax'                          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'notice_address_licensor'      => new sfValidatorString(array('required' => false)),
      'ip_notification_method_id'    => new sfValidatorPropelChoice(array('model' => 'IpNotificationMethod', 'column' => 'id', 'required' => false)),
      'ip_notification_uri'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ip_notification_username'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'ip_notification_password'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'ip_notification_contact_id'   => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id', 'required' => false)),
      'ip_notification_force_manual' => new sfValidatorBoolean(array('required' => false)),
      'note'                         => new sfValidatorString(array('required' => false)),
      'updated_at'                   => new sfValidatorDateTime(),
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
