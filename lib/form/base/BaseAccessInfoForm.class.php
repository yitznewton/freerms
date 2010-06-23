<?php

/**
 * AccessInfo form base class.
 *
 * @method AccessInfo getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAccessInfoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'onsite_access_uri'      => new sfWidgetFormInputText(),
      'offsite_access_uri'     => new sfWidgetFormInputText(),
      'onsite_auth_method_id'  => new sfWidgetFormPropelChoice(array('model' => 'AuthMethod', 'add_empty' => true)),
      'offsite_auth_method_id' => new sfWidgetFormPropelChoice(array('model' => 'AuthMethod', 'add_empty' => true)),
      'access_username'        => new sfWidgetFormInputText(),
      'access_password'        => new sfWidgetFormInputText(),
      'access_password_note'   => new sfWidgetFormTextarea(),
      'concurrent_users'       => new sfWidgetFormInputText(),
      'ezproxy_cfg_entry'      => new sfWidgetFormTextarea(),
      'referral_note'          => new sfWidgetFormTextarea(),
      'note'                   => new sfWidgetFormTextarea(),
      'deleted_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'onsite_access_uri'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'offsite_access_uri'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'onsite_auth_method_id'  => new sfValidatorPropelChoice(array('model' => 'AuthMethod', 'column' => 'id', 'required' => false)),
      'offsite_auth_method_id' => new sfValidatorPropelChoice(array('model' => 'AuthMethod', 'column' => 'id', 'required' => false)),
      'access_username'        => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'access_password'        => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'access_password_note'   => new sfValidatorString(array('required' => false)),
      'concurrent_users'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'ezproxy_cfg_entry'      => new sfValidatorString(array('required' => false)),
      'referral_note'          => new sfValidatorString(array('required' => false)),
      'note'                   => new sfValidatorString(array('required' => false)),
      'deleted_at'             => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('access_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccessInfo';
  }


}
