<?php

class DatabaseUsageTable extends UsageTable
{
  /**
   * @param int $id ID to get statistics for
   * @param string $table Table to get statistics for
   * @param string $labelColumn Column to use as group label
   * @param array $filters
   */
  public function getStatistics($id, $table, $labelColumn, array $filters = array())
  {
    $foreignKey = $table . '_id';

    if ($table === 'database') {
      $table = 'freerms_database';
      $groupTable = 'library';
      $groupKey = 'library_id';
    }
    elseif ($table !== 'library') {
      throw new InvalidArgumentException("Invalid table $table");
    }
    else {
      $groupTable = 'freerms_database';
      $groupKey = 'database_id';
    }

    if (!in_array($labelColumn, array('code', 'title'))) {
      throw new InvalidArgumentException("Invalid column $labelColumn");
    }

    $filterStrings = array();
    $params = array(':id' => $id);

    if (isset($filters['timestamp']['from'])) {
      $params[':from'] = $filters['timestamp']['from'];
      $filterStrings[] = 'SUBSTR(du.timestamp, 1, 7) >= :from';
    }

    if (isset($filters['timestamp']['to'])) {
      $params[':to'] = $filters['timestamp']['to'];
      $filterStrings[] = 'SUBSTR(du.timestamp, 1, 7) <= :to';
    }

    $q = 'SELECT SUBSTR(du.timestamp, 1, 7) as month, '
         . "f.id, f.$labelColumn, COUNT(*) "
         . 'FROM database_usage du '
         . "JOIN $groupTable f ON du.$groupKey = f.id "
         . "WHERE du.$foreignKey = :id "
         ;

    if ($filterStrings) {
      $q .= 'AND ' . implode(' AND ', $filterStrings) . ' ';
    }

    $q .= 'GROUP BY f.id, month '
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

  public function getShareForDatabase($id, $columnName, array $filters = array())
  {
    if (!in_array($columnName, array('is_mobile', 'is_onsite'))) {
      throw new InvalidArgumentException("Invalid column $columnName");
    }

    $filterStrings = array();
    $params = array(':id' => $id);

    if (isset($filters['timestamp']['from'])) {
      $params[':from'] = $filters['timestamp']['from'];
      $filterStrings[] = 'SUBSTR(du.timestamp, 1, 7) >= :from';
    }

    if (isset($filters['timestamp']['to'])) {
      $params[':to'] = $filters['timestamp']['to'];
      $filterStrings[] = 'SUBSTR(du.timestamp, 1, 7) <= :to';
    }

    $q = "SELECT du.$columnName, COUNT(*) as n "
         . 'FROM database_usage du '
         . 'WHERE du.database_id = :id '
         ;

    if ($filterStrings) {
      $q .= 'AND ' . implode(' AND ', $filterStrings) . ' ';
    }

    $q .= "GROUP BY du.$columnName ";

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($q);

    $st->execute($params);

    // start with false and true both at zero in case either has no usages
    $ret = array(
      0 => 0,
      1 => 0,
    );

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $ret[$row[$columnName]] = $row['n'];
    }

    return $ret;
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
