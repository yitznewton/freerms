<?php

class DatabaseUsageTable extends UsageTable
{
  /**
   * @param int $id
   * @param string $foregnKey
   * @param string $shareColumn
   * @param array $filters
   * @return array
   */
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
