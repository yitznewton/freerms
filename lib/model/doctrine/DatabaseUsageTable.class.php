<?php

class DatabaseUsageTable extends UsageTable
{
  /**
   * @param int $id Database ID to get statistics for
   * @param array $filters
   */
  public function getStatisticsForDatabase($id, array $filters = array())
  {
    $filterStrings = array();
    $params = array();

    if (isset($filters['timestamp']['from'])) {
      $params[':from'] = $filters['timestamp']['from'];
      $filterStrings[] = 'SUBSTR(du.timestamp, 1, 7) >= :from';
    }

    if (isset($filters['timestamp']['to'])) {
      $params[':to'] = $filters['timestamp']['to'];
      $filterStrings[] = 'SUBSTR(du.timestamp, 1, 7) <= :to';
    }

    $q = 'SELECT SUBSTR(du.timestamp, 1, 7) as month, '
         . 'l.id, l.code, COUNT(*) '
         . 'FROM database_usage du '
         . 'JOIN library l ON du.library_id = l.id '
         ;

    if ($filterStrings) {
      $q .= 'WHERE ' . implode(' AND ', $filterStrings) . ' ';
    }

    $q .= 'GROUP BY l.id, month '
          . 'ORDER BY month '
          ;

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($q);

    $st->execute($params);

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $data[$row['id']]['code'] = $row['code'];
      $data[$row['id']]['months'][$row['month']] = $row['COUNT(*)'];
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
