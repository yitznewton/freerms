<?php

/**
 * AutoEmailIpRegContact filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAutoEmailIpRegContactFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'last_name'  => new sfWidgetFormFilterInput(),
      'first_name' => new sfWidgetFormFilterInput(),
      'email'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'last_name'  => new sfValidatorPass(array('required' => false)),
      'first_name' => new sfValidatorPass(array('required' => false)),
      'email'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('auto_email_ip_reg_contact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AutoEmailIpRegContact';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'last_name'  => 'Text',
      'first_name' => 'Text',
      'email'      => 'Text',
    );
  }
}
