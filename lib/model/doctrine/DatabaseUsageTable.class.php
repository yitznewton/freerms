<?php

class DatabaseUsageTable extends UsageTable
{
  /**
   * @param int $id Database ID to get statistics for
   */
  public function getStatisticsForDatabase($id)
  {
    $q = 'SELECT SUBSTR(du.timestamp, 1, 7) as month, '
         . 'l.code, COUNT(*) '
         . 'FROM database_usage du '
         . 'JOIN library l ON du.library_id = l.id '
         . 'GROUP BY l.id, month '
         . 'ORDER BY month '
         ;

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->query($q);

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $data[$row['code']][$row['month']] = $row['COUNT(*)'];
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
