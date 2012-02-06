<?php

/**
 * DatabaseSubject form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DatabaseSubjectForm extends BaseDatabaseSubjectForm
{
  public function configure()
  {
    $this->widgetSchema['featured_weight'] = new sfWidgetFormInput(array(
      'label' => $this->getObject()->getDatabase()->getTitle(),
    ), array(
      'class' => 'weight',
    ));

    $this->widgetSchema['database_id']->setAttribute('class', 'database-id');

    $this->widgetSchema->setAttribute('class', 'DatabaseSubjectForm');

    $this->validatorSchema['featured_weight'] = new sfValidatorInteger();
  }
}

