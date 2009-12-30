<?php

/**
 * AccessInfo form base class.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAccessInfoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'onsite_access_uri'      => new sfWidgetFormInput(),
      'offsite_access_uri'     => new sfWidgetFormInput(),
      'onsite_auth_method_id'  => new sfWidgetFormPropelChoice(array('model' => 'AuthMethod', 'add_empty' => true)),
      'offsite_auth_method_id' => new sfWidgetFormPropelChoice(array('model' => 'AuthMethod', 'add_empty' => true)),
      'access_username'        => new sfWidgetFormInput(),
      'access_password'        => new sfWidgetFormInput(),
      'access_password_note'   => new sfWidgetFormTextarea(),
      'concurrent_users'       => new sfWidgetFormInput(),
      'ezproxy_cfg_entry'      => new sfWidgetFormTextarea(),
      'referral_note'          => new sfWidgetFormTextarea(),
      'note'                   => new sfWidgetFormTextarea(),
      'deleted_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'AccessInfo', 'column' => 'id', 'required' => false)),
      'onsite_access_uri'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'offsite_access_uri'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'onsite_auth_method_id'  => new sfValidatorPropelChoice(array('model' => 'AuthMethod', 'column' => 'id', 'required' => false)),
      'offsite_auth_method_id' => new sfValidatorPropelChoice(array('model' => 'AuthMethod', 'column' => 'id', 'required' => false)),
      'access_username'        => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'access_password'        => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'access_password_note'   => new sfValidatorString(array('required' => false)),
      'concurrent_users'       => new sfValidatorInteger(array('required' => false)),
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
