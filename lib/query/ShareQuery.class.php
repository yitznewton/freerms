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
    $this->selects[] = "t.$this->shareColumn";
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'SUBSTR(t.timestamp, 1, 7) AS month';

    if (isset($filters['timestamp'])) {
      $this->applyTimeFilters($filters['timestamp']);
    }

    $this->groupByColumn = $this->shareColumn;

    $this->execute();

    // start with false and true both at zero in case either has no usages
    $ret = array(
      0 => 0,
      1 => 0,
    );

    while ($row = $this->fetchRow()) {
      $ret[$row[$this->shareColumn]] = $row['COUNT(*)'];
    }

    return $ret;
  }
}

