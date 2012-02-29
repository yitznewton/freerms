<?php

class IpRangeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip'          => new sfWidgetFormFilterInput(array(
        'with_empty' => false,
        'label' => 'Beginning of IP')),

      'is_active'   => new sfWidgetFormChoice(array(
        'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'),
        'label' => 'Active')),

      'is_excluded' => new sfWidgetFormChoice(array(
        'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'),
        'label' => 'Excluded')),

      'library_id'    => new sfWidgetFormDoctrineChoice(array(
        'model' => $this->getRelatedModelName('Library'),
        'add_empty' => true)),
    ));

    $this->setValidators(array(
      'ip'   => new sfValidatorPass(array('required' => false)),

      'is_active'     => new sfValidatorChoice(array(
        'required' => false,
        'choices' => array('', 1, 0))),

      'is_excluded'   => new sfValidatorChoice(array(
        'required' => false,
        'choices' => array('', 1, 0))),

      'library_id'    => new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model' => $this->getRelatedModelName('Library'),
        'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('ip_range_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IpRange';
  }

  public function getFields()
  {
    return array(
      'ip'          => 'Text',
      'is_active'   => 'Boolean',
      'is_excluded' => 'Boolean',
      'library_id'    => 'ForeignKey',
    );
  }

  protected function addIpColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if ($values['text'] === '') {
      return;
    }

    $sortString   = IpRange::createSortString($values['text']);
    $stringLength = strlen($sortString);

    $query
      ->andWhere("SUBSTRING(r.start_ip_sort, 1, $stringLength) <= ?", $sortString)
      ->andWhere("SUBSTRING(r.end_ip_sort, 1, $stringLength) >= ?", $sortString)
      ;
  }
}

