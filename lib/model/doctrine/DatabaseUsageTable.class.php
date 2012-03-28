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

    $q .= 'GROUP BY f.id, month ';

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($q);

    $st->execute($params);

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $data[$row['id']]['label'] = $row[$labelColumn];
      $data[$row['id']]['months'][$row['month']] = $row['COUNT(*)'];
    }

    // descending sort by sum of COUNT
    uasort($data, function($a, $b) {
      $sum = array_sum($b['months']) - array_sum($a['months']);

      if ($sum === 0) {
        return 0;
      }
      elseif ($sum > 0) {
        return 1;
      }
      else {
        return -1;
      }
    });

    return $data;
  }

  public function getShare($id, $foreignKey, $shareColumn, array $filters = array())
  {
    if (!in_array($foreignKey, array('database_id', 'library_id'))) {
      throw new InvalidArgumentException("Invalid column $foreignKey");
    }

    if (!in_array($shareColumn, array('is_mobile', 'is_onsite'))) {
      throw new InvalidArgumentException("Invalid column $shareColumn");
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

    $q = "SELECT du.$shareColumn, COUNT(*) as n "
         . 'FROM database_usage du '
         . "WHERE du.$foreignKey = :id "
         ;

    if ($filterStrings) {
      $q .= 'AND ' . implode(' AND ', $filterStrings) . ' ';
    }

    $q .= "GROUP BY du.$shareColumn ";

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($q);

    $st->execute($params);

    // start with false and true both at zero in case either has no usages
    $ret = array(
      0 => 0,
      1 => 0,
    );

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $ret[$row[$shareColumn]] = $row['n'];
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
