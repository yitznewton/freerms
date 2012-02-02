<?php

/**
 * Subject
 * 
 * @package    freerms
 * @subpackage model
 */
class Subject extends BaseSubject
{
  /**
   * @return Doctrine_Collection
   */
  public function getDatabaseSubjects()
  { 
    $query = Doctrine_Core::getTable('DatabaseSubject')
      ->createQuery('ds')
      ->leftJoin('ds.Database d')
      ->where('ds.subject_id = ?', $this->getId())
      ->orderBy('d.sort_title');

    return $query->execute();
  }
}

