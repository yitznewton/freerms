<?php

/**
 * EResource form base class.
 *
 * @method EResource getObject() Returns the current form's model object
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEResourceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'alt_id'                           => new sfWidgetFormInputText(),
      'subscription_number'              => new sfWidgetFormInputText(),
      'title'                            => new sfWidgetFormInputText(),
      'sort_title'                       => new sfWidgetFormInputText(),
      'alt_title'                        => new sfWidgetFormInputText(),
      'language'                         => new sfWidgetFormInputText(),
      'description'                      => new sfWidgetFormTextarea(),
      'public_note'                      => new sfWidgetFormTextarea(),
      'suppression'                      => new sfWidgetFormInputCheckbox(),
      'product_unavailable'              => new sfWidgetFormInputCheckbox(),
      'acq_id'                           => new sfWidgetFormPropelChoice(array('model' => 'Acquisition', 'add_empty' => true)),
      'access_info_id'                   => new sfWidgetFormPropelChoice(array('model' => 'AccessInfo', 'add_empty' => true)),
      'admin_info_id'                    => new sfWidgetFormPropelChoice(array('model' => 'AdminInfo', 'add_empty' => true)),
      'created_at'                       => new sfWidgetFormDateTime(),
      'updated_at'                       => new sfWidgetFormDateTime(),
      'deleted_at'                       => new sfWidgetFormDateTime(),
      'e_resource_db_subject_assoc_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'DbSubject')),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'alt_id'                           => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'subscription_number'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'title'                            => new sfValidatorString(array('max_length' => 255)),
      'sort_title'                       => new sfValidatorString(array('max_length' => 255)),
      'alt_title'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'language'                         => new sfValidatorString(array('max_length' => 25)),
      'description'                      => new sfValidatorString(array('required' => false)),
      'public_note'                      => new sfValidatorString(array('required' => false)),
      'suppression'                      => new sfValidatorBoolean(),
      'product_unavailable'              => new sfValidatorBoolean(),
      'acq_id'                           => new sfValidatorPropelChoice(array('model' => 'Acquisition', 'column' => 'id', 'required' => false)),
      'access_info_id'                   => new sfValidatorPropelChoice(array('model' => 'AccessInfo', 'column' => 'id', 'required' => false)),
      'admin_info_id'                    => new sfValidatorPropelChoice(array('model' => 'AdminInfo', 'column' => 'id', 'required' => false)),
      'created_at'                       => new sfValidatorDateTime(),
      'updated_at'                       => new sfValidatorDateTime(),
      'deleted_at'                       => new sfValidatorDateTime(array('required' => false)),
      'e_resource_db_subject_assoc_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'DbSubject', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'EResource', 'column' => array('alt_id')))
    );

    $this->widgetSchema->setNameFormat('e_resource[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EResource';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['e_resource_db_subject_assoc_list']))
    {
      $values = array();
      foreach ($this->object->getEResourceDbSubjectAssocs() as $obj)
      {
        $values[] = $obj->getDbSubjectId();
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
    $c->add(EResourceDbSubjectAssocPeer::ER_ID, $this->object->getPrimaryKey());
    EResourceDbSubjectAssocPeer::doDelete($c, $con);

    $values = $this->getValue('e_resource_db_subject_assoc_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EResourceDbSubjectAssoc();
        $obj->setErId($this->object->getPrimaryKey());
        $obj->setDbSubjectId($value);
        $obj->save();
      }
    }
  }

}
