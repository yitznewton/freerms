<?php

/**
 * DbSubject form base class.
 *
 * @method DbSubject getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDbSubjectForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'label'                            => new sfWidgetFormInputText(),
      'slug'                             => new sfWidgetFormInputText(),
      'e_resource_db_subject_assoc_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'EResource')),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'label'                            => new sfValidatorString(array('max_length' => 100)),
      'slug'                             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'e_resource_db_subject_assoc_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'EResource', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('db_subject[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DbSubject';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['e_resource_db_subject_assoc_list']))
    {
      $values = array();
      foreach ($this->object->getEResourceDbSubjectAssocs() as $obj)
      {
        $values[] = $obj->getErId();
      }

      $this->setDefault('e_resource_db_subject_assoc_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEResourceDbSubjectAssocList($con);
  }

  public function saveEResourceDbSubjectAssocList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['e_resource_db_subject_assoc_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, $this->object->getPrimaryKey());
    EResourceDbSubjectAssocPeer::doDelete($c, $con);

    $values = $this->getValue('e_resource_db_subject_assoc_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EResourceDbSubjectAssoc();
        $obj->setDbSubjectId($this->object->getPrimaryKey());
        $obj->setErId($value);
        $obj->save();
      }
    }
  }

}
