<?php

class ShareQuery extends ReportSqlQuery
{
  /**
   * @var Doctrine_Table
   */
  protected $table;
  /**
   * @var string
   */
  protected $shareColumn;

  /**
   * @param Doctrine_Table $table
   * @param string $shareColumn
   */
  public function __construct(Doctrine_Table $table, $shareColumn)
  {
    $this->table = $table;
    $this->shareColumn = $this->sanitize($shareColumn);
  }

  /**
   * @param array $filters
   * @return array Sorted array of results
   */
  public function get(array $filters)
  {
    $selects = array();
    $wheres = array();
    $params = array();

    if (isset($filters['timestamp']['from'])) {
      $params[':from'] = $filters['timestamp']['from'];
      $wheres[] = 'SUBSTR(t.timestamp, 1, 7) >= :from';
    }

    if (isset($filters['timestamp']['to'])) {
      $params[':to'] = $filters['timestamp']['to'];
      $wheres[] = 'SUBSTR(t.timestamp, 1, 7) <= :to';
    }

    $selects[] = "t.$this->shareColumn";
    $selects[] = 'COUNT(*)';

    $q = 'SELECT '
         . implode(', ', $selects) . ' '
         . 'FROM ' . $this->table->getTableName() . ' t '
         . 'WHERE '
         . implode(' AND ', $wheres) . ' '
         . "GROUP BY t.$this->shareColumn "
         ;

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($q);

    $st->execute($params);

    // start with false and true both at zero in case either has no usages
    $ret = array(
      0 => 0,
      1 => 0,
    );

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $ret[$row[$this->shareColumn]] = $row['COUNT(*)'];
    }

    return $ret;
  }
}

