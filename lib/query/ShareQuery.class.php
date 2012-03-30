<?php

class ShareQuery extends ReportSqlQuery
{
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
    $params = array();

    if (isset($filters['timestamp']['from'])) {
      $params[':from'] = $filters['timestamp']['from'];
      $this->wheres[] = 'month >= :from';
    }

    if (isset($filters['timestamp']['to'])) {
      $params[':to'] = $filters['timestamp']['to'];
      $this->wheres[] = 'month <= :to';
    }

    $this->selects[] = "t.$this->shareColumn";
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'SUBSTR(t.timestamp, 1,7) as month';

    $this->groupByColumn = $this->shareColumn;

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($this->getSql());

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

