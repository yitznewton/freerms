<?php

/**
 * DatabaseTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DatabaseTable extends Doctrine_Table
{
  /**
   * @param array int[] $libraryIds
   * @return Doctrine_Collection
   */
  public static function findByLibraryIdsAndSubject(
    array $libraryIds, Subject $subject = null)
  {
    $q = self::getInstance()->createQuery('d')
      ->leftJoin('d.Libraries l')
      ->whereIn('l.id', $libraryIds)
      ->andWhere('d.is_hidden = false')
      ->orderBy('LOWER(d.sort_title)')
      ;

    if ($subject) {
      $q->leftJoin('d.DatabaseSubjects ds')
        ->andWhere('ds.subject_id = ?', $subject->getId())
        ;
    }

    return $q->execute();
  }

  /**
   * @param array int[] $libraryIds
   * @param Subject $subject
   * @return Doctrine_Collection
   */
  public function findFeaturedByLibraryIdsAndSubject(
    array $libraryIds, Subject $subject)
  {
    $q = self::getInstance()->createQuery('d')
      ->leftJoin('d.Libraries l')
      ->leftJoin('d.DatabaseSubjects ds')
      ->whereIn('l.id', $libraryIds)
      ->andWhere('ds.subject_id = ?', $subject->getId())
      ->andWhere('ds.featured_weight != -1')
      ->andWhere('d.is_hidden = false')
      ->orderBy('ds.featured_weight ASC, LOWER(d.sort_title) ASC')
      ;

    return $q->execute();
  }

  /**
   * @param array int[] $libraryIds
   * @return Doctrine_Collection
   */
  public function findGeneralFeaturedByLibraryIds(array $libraryIds)
  {
    $q = self::getInstance()->createQuery('d')
      ->leftJoin('d.Libraries l')
      ->whereIn('l.id', $libraryIds)
      ->andWhere('d.is_featured = true')
      ->andWhere('d.is_hidden = false')
      ->orderBy('d.featured_weight ASC, LOWER(d.sort_title) ASC')
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
