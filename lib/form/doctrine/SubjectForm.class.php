<?php

/**
 * Subject form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SubjectForm extends BaseSubjectForm
{
  public function configure()
  {
    unset(
      $this['databases_list']
    );

    if ($this->getObject()->isNew()) {
      return;
    }

    $databaseSubjects = Doctrine_Core::getTable('DatabaseSubject')
      ->createQuery('ds')
      ->leftJoin('ds.Database d')
      ->where('ds.subject_id = ?', $this->getObject()->getId())
      ->orderBy('d.sort_title')
      ->execute()
      ;

    if ($databaseSubjects->count() === 0) {
      return;
    }
    
    $containerForm = new sfForm();

    foreach ($this->getObject()->getDatabaseSubjects() as $ds) {
      $containerForm->embedForm($ds->getDatabaseId(),
        new DatabaseSubjectForm($ds));
    }

    $this->embedForm('DatabaseSubject', $containerForm);

    $this->widgetSchema['DatabaseSubject']->setLabel('Database weight');
  }
}

