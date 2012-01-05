<?php

/**
 * DatabaseTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DatabaseTable extends Doctrine_Table
{
  /**
   * @param Library $library
   * @return Doctrine_Collection
   */
  public static function findByLibrary(Library $library)
  {
    $q = self::getInstance()->createQuery('d')
      ->leftJoin('d.Libraries l')
      ->where('l.id = ?', $library->getId())
      ->andWhere('d.is_hidden = false')
      ->orderBy('LOWER(d.sort_title)')
      ;

    return $q->execute();
  }

  /**
   * @param array int[] $libraryIds
   * @param Subject $subject
   * @return Doctrine_Collection
   */
  public static function findFeaturedByLibraryIdsAndSubject(
    array $libraryIds, Subject $subject)
  {
    $q = self::getInstance()->createQuery('d')
      ->leftJoin('d.Libraries l')
      ->leftJoin('d.DatabaseSubjects ds')
      ->where('l.id IN ?', $libraryIds)
      ->andWhere('ds.subject_id = ?', $subject->getId())
      ->andWhere('ds.featured_weight != -1')
      ->andWhere('d.is_hidden = false')
      ->orderBy('ds.featured_weight', 'd.sort_title')
      ;

    return $q->execute();
  }

  /**
   * Returns an instance of this class.
   *
   * @return object DatabaseTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Database');
  }
}
