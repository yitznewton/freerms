<?php

/**
 * AuthMethod filter form base class.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAuthMethodFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'label'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_valid_onsite'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_valid_offsite' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'label'            => new sfValidatorPass(array('required' => false)),
      'is_valid_onsite'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_valid_offsite' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('auth_method_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthMethod';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'label'            => 'Text',
      'is_valid_onsite'  => 'Boolean',
      'is_valid_offsite' => 'Boolean',
    );
  }
}
