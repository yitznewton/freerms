<?php

/**
 * Library form base class.
 *
 * @method Library getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLibraryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'code'               => new sfWidgetFormInputText(),
      'alt_name'           => new sfWidgetFormInputText(),
      'address'            => new sfWidgetFormTextarea(),
      'ezproxy_host'       => new sfWidgetFormInputText(),
      'ezproxy_key'        => new sfWidgetFormInputText(),
      'cost_center_no'     => new sfWidgetFormInputText(),
      'fte'                => new sfWidgetFormInputText(),
      'note'               => new sfWidgetFormTextarea(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'acq_lib_assoc_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Acquisition')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Library', 'column' => 'id', 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 100)),
      'code'               => new sfValidatorString(array('max_length' => 10)),
      'alt_name'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'            => new sfValidatorString(array('required' => false)),
      'ezproxy_host'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'ezproxy_key'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cost_center_no'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'fte'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'note'               => new sfValidatorString(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(),
      'acq_lib_assoc_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Acquisition', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Library', 'column' => array('code')))
    );

    $this->widgetSchema->setNameFormat('library[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Library';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['acq_lib_assoc_list']))
    {
      $values = array();
      foreach ($this->object->getAcqLibAssocs() as $obj)
      {
        $values[] = $obj->getAcqId();
      }

      $this->setDefault('acq_lib_assoc_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAcqLibAssocList($con);
  }

  public function saveAcqLibAssocList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['acq_lib_assoc_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AcqLibAssocPeer::LIB_ID, $this->object->getPrimaryKey());
    AcqLibAssocPeer::doDelete($c, $con);

    $values = $this->getValue('acq_lib_assoc_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AcqLibAssoc();
        $obj->setLibId($this->object->getPrimaryKey());
        $obj->setAcqId($value);
        $obj->save();
      }
    }
  }

}
