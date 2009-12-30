<?php

/**
 * IpRange form base class.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseIpRangeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'lib_id'           => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => false)),
      'start_ip'         => new sfWidgetFormInput(),
      'end_ip'           => new sfWidgetFormInput(),
      'active_indicator' => new sfWidgetFormInputCheckbox(),
      'proxy_indicator'  => new sfWidgetFormInputCheckbox(),
      'note'             => new sfWidgetFormInput(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'IpRange', 'column' => 'id', 'required' => false)),
      'lib_id'           => new sfValidatorPropelChoice(array('model' => 'Library', 'column' => 'id')),
      'start_ip'         => new sfValidatorString(array('max_length' => 15)),
      'end_ip'           => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'active_indicator' => new sfValidatorBoolean(),
      'proxy_indicator'  => new sfValidatorBoolean(),
      'note'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ip_range[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRange';
  }


}
