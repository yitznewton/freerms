<?php

/**
 * Acquisition form base class.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAcquisitionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'note'               => new sfWidgetFormTextarea(),
      'acq_lib_assoc_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Library')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Acquisition', 'column' => 'id', 'required' => false)),
      'note'               => new sfValidatorString(array('required' => false)),
      'acq_lib_assoc_list' => new sfValidatorPropelChoiceMany(array('model' => 'Library', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('acquisition[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acquisition';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['acq_lib_assoc_list']))
    {
      $values = array();
      foreach ($this->object->getAcqLibAssocs() as $obj)
      {
        $values[] = $obj->getLibId();
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

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AcqLibAssocPeer::ACQ_ID, $this->object->getPrimaryKey());
    AcqLibAssocPeer::doDelete($c, $con);

    $values = $this->getValue('acq_lib_assoc_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AcqLibAssoc();
        $obj->setAcqId($this->object->getPrimaryKey());
        $obj->setLibId($value);
        $obj->save();
      }
    }
  }

}
