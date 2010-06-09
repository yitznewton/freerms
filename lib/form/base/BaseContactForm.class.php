<?php

/**
 * Contact form base class.
 *
 * @method Contact getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseContactForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'last_name'                      => new sfWidgetFormInputText(),
      'first_name'                     => new sfWidgetFormInputText(),
      'title'                          => new sfWidgetFormInputText(),
      'role'                           => new sfWidgetFormInputText(),
      'address'                        => new sfWidgetFormTextarea(),
      'fax'                            => new sfWidgetFormInputText(),
      'note'                           => new sfWidgetFormTextarea(),
      'org_id'                         => new sfWidgetFormPropelChoice(array('model' => 'Organization', 'add_empty' => true)),
      'updated_at'                     => new sfWidgetFormDateTime(),
      'auto_email_ip_reg_event_list'   => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'IpRange')),
      'manual_email_ip_reg_event_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'IpRange')),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorPropelChoice(array('model' => 'Contact', 'column' => 'id', 'required' => false)),
      'last_name'                      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'first_name'                     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'title'                          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'role'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'                        => new sfValidatorString(array('required' => false)),
      'fax'                            => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'note'                           => new sfValidatorString(array('required' => false)),
      'org_id'                         => new sfValidatorPropelChoice(array('model' => 'Organization', 'column' => 'id', 'required' => false)),
      'updated_at'                     => new sfValidatorDateTime(),
      'auto_email_ip_reg_event_list'   => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'IpRange', 'required' => false)),
      'manual_email_ip_reg_event_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'IpRange', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['auto_email_ip_reg_event_list']))
    {
      $values = array();
      foreach ($this->object->getAutoEmailIpRegEvents() as $obj)
      {
        $values[] = $obj->getIpRangeId();
      }

      $this->setDefault('auto_email_ip_reg_event_list', $values);
    }

    if (isset($this->widgetSchema['manual_email_ip_reg_event_list']))
    {
      $values = array();
      foreach ($this->object->getManualEmailIpRegEvents() as $obj)
      {
        $values[] = $obj->getIpRangeId();
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
    $c->add(AutoEmailIpRegEventPeer::CONTACT_ID, $this->object->getPrimaryKey());
    AutoEmailIpRegEventPeer::doDelete($c, $con);

    $values = $this->getValue('auto_email_ip_reg_event_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AutoEmailIpRegEvent();
        $obj->setContactId($this->object->getPrimaryKey());
        $obj->setIpRangeId($value);
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
    $c->add(ManualEmailIpRegEventPeer::CONTACT_ID, $this->object->getPrimaryKey());
    ManualEmailIpRegEventPeer::doDelete($c, $con);

    $values = $this->getValue('manual_email_ip_reg_event_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ManualEmailIpRegEvent();
        $obj->setContactId($this->object->getPrimaryKey());
        $obj->setIpRangeId($value);
        $obj->save();
      }
    }
  }

}
