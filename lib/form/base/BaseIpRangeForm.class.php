<?php

/**
 * IpRange form base class.
 *
 * @method IpRange getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseIpRangeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'lib_id'                         => new sfWidgetFormPropelChoice(array('model' => 'Library', 'add_empty' => false)),
      'start_ip'                       => new sfWidgetFormInputText(),
      'end_ip'                         => new sfWidgetFormInputText(),
      'active_indicator'               => new sfWidgetFormInputCheckbox(),
      'proxy_indicator'                => new sfWidgetFormInputCheckbox(),
      'note'                           => new sfWidgetFormInputText(),
      'updated_at'                     => new sfWidgetFormDateTime(),
      'deleted_at'                     => new sfWidgetFormDateTime(),
      'auto_email_ip_reg_event_list'   => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Contact')),
      'manual_email_ip_reg_event_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Contact')),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorPropelChoice(array('model' => 'IpRange', 'column' => 'id', 'required' => false)),
      'lib_id'                         => new sfValidatorPropelChoice(array('model' => 'Library', 'column' => 'id')),
      'start_ip'                       => new sfValidatorString(array('max_length' => 15)),
      'end_ip'                         => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'active_indicator'               => new sfValidatorBoolean(),
      'proxy_indicator'                => new sfValidatorBoolean(),
      'note'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at'                     => new sfValidatorDateTime(),
      'deleted_at'                     => new sfValidatorDateTime(array('required' => false)),
      'auto_email_ip_reg_event_list'   => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Contact', 'required' => false)),
      'manual_email_ip_reg_event_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Contact', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ip_range[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRange';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['auto_email_ip_reg_event_list']))
    {
      $values = array();
      foreach ($this->object->getAutoEmailIpRegEvents() as $obj)
      {
        $values[] = $obj->getContactId();
      }

      $this->setDefault('auto_email_ip_reg_event_list', $values);
    }

    if (isset($this->widgetSchema['manual_email_ip_reg_event_list']))
    {
      $values = array();
      foreach ($this->object->getManualEmailIpRegEvents() as $obj)
      {
        $values[] = $obj->getContactId();
      }

      $this->setDefault('manual_email_ip_reg_event_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAutoEmailIpRegEventList($con);
    $this->saveManualEmailIpRegEventList($con);
  }

  public function saveAutoEmailIpRegEventList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['auto_email_ip_reg_event_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AutoEmailIpRegEventPeer::IP_RANGE_ID, $this->object->getPrimaryKey());
    AutoEmailIpRegEventPeer::doDelete($c, $con);

    $values = $this->getValue('auto_email_ip_reg_event_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AutoEmailIpRegEvent();
        $obj->setIpRangeId($this->object->getPrimaryKey());
        $obj->setContactId($value);
        $obj->save();
      }
    }
  }

  public function saveManualEmailIpRegEventList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['manual_email_ip_reg_event_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ManualEmailIpRegEventPeer::IP_RANGE_ID, $this->object->getPrimaryKey());
    ManualEmailIpRegEventPeer::doDelete($c, $con);

    $values = $this->getValue('manual_email_ip_reg_event_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ManualEmailIpRegEvent();
        $obj->setIpRangeId($this->object->getPrimaryKey());
        $obj->setContactId($value);
        $obj->save();
      }
    }
  }

}
