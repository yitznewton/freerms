<?php

class DatabaseUsageTable extends UsageTable
{
  /**
   * @param int $id Database ID to get statistics for
   */
  public function getStatisticsForDatabase($id)
  {
    $q = $this->createQuery('du')
      ->select('du.database_id, SUBSTR(du.timestamp, 1, 7) AS month, l.code, COUNT(*)')
      ->leftJoin('du.Library l')
      ->where('du.database_id = ?', $id)
      ->groupBy('l.id, month')
      ->orderBy('month')
      ;

    $data = array();

    foreach ($q->execute()->toArray() as $row) {
      $data[$row['Library']['code']][$row['month']] = $row['COUNT'];
    }

    return $data;
  }

    /**
     * Returns an instance of this class.
     *
     * @return object DatabaseUsageTable
     */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('DatabaseUsage');
  }
}
