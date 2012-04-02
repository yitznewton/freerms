<?php

class StatsSqlQuery extends ReportSqlQuery
{
  /**
   * @param Doctrine_Table $table
   * @param PDO $pdo
   */
  public function __construct(Doctrine_Table $table, PDO $pdo = null)
  {
    parent::__construct($table, $pdo);

    $this->selects[] = 'SUBSTR(t.timestamp, 1, 7) AS month';
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'library_id';

    if ($this->table->hasColumn('host')) {
      $this->selects[] = 't.host';
    }

    $libraryTableName = $this->getTableName('Library');
    $this->joins[] = "$libraryTableName l ON t.library_id = l.id";
  }

  /**
   * @return array Sorted array of results
   */
  public function get()
  {
    if (isset($this->params[':database_id'])) {
      $databaseTableName = $this->getTableName('Database');

      $this->selects[] = 'd.title';
      $this->joins[] = "$databaseTableName d ON t.database_id = d.id";
    }

    $this->execute();

    $data = array();

    while ($row = $this->fetchRow()) {
      $data[$row[$this->groupByColumn]]['label'] = $row[$this->labelColumn];
      $data[$row[$this->groupByColumn]]['months'][$row['month']] = $row['COUNT(*)'];
    }

    if ($data) {
      uasort($data, array($this, 'sort'));
    }

    return $data;
  }

  /**
   * Descending sort by sum of COUNT
   *
   * @param array $data
   */
  protected function sort($a, $b)
  {
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
  }
}

