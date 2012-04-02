<?php

class ShareSqlQuery extends ReportSqlQuery
{
  /**
   * @var string
   */
  protected $shareColumn;

  /**
   * @param Doctrine_Table $table
   * @param string $shareColumn
   * @param PDO $pdo
   */
  public function __construct(
    Doctrine_Table $table, $shareColumn, PDO $pdo = null)
  {
    parent::__construct($table, $pdo);

    $this->shareColumn = $this->sanitize($shareColumn);

    $this->selects[] = "t.$this->shareColumn";
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'SUBSTR(t.timestamp, 1, 7) AS month';

    $this->groupByColumn = $this->shareColumn;
  }

  /**
   * @return array Sorted array of results
   */
  public function get()
  {
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

