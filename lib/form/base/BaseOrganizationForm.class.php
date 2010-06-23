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
      'web_admin_uri'           => new sfWidgetFormInputText(),
      'web_admin_username'      => new sfWidgetFormInputText(),
      'web_admin_password'      => new sfWidgetFormInputText(),
      'web_contact_form_uri'    => new sfWidgetFormInputText(),
      'ip_reg_method_id'        => new sfWidgetFormPropelChoice(array('model' => 'IpRegMethod', 'add_empty' => true)),
      'ip_reg_contact_id'       => new sfWidgetFormPropelChoice(array('model' => 'Contact', 'add_empty' => true)),
      'usage_stats_uri'         => new sfWidgetFormInputText(),
      'usage_stats_username'    => new sfWidgetFormInputText(),
      'usage_stats_password'    => new sfWidgetFormInputText(),
      'note'                    => new sfWidgetFormTextarea(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 255)),
      'alt_name'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'account_number'          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'address'                 => new sfValidatorString(array('required' => false)),
      'phone'                   => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'fax'                     => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'notice_address_licensor' => new sfValidatorString(array('required' => false)),
      'web_admin_uri'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'web_admin_username'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'web_admin_password'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'web_contact_form_uri'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ip_reg_method_id'        => new sfValidatorPropelChoice(array('model' => 'IpRegMethod', 'column' => 'id', 'required' => false)),
      'ip_reg_contact_id'       => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id', 'required' => false)),
      'usage_stats_uri'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'usage_stats_username'    => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'usage_stats_password'    => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'note'                    => new sfValidatorString(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Organization', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('organization[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Organization';
  }


}
