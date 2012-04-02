<?php

class StatsSqlQuery extends ReportSqlQuery
{
  /**
   * @return array Sorted array of results
   */
  public function get()
  {
    $this->execute();

    $data = array();

    while ($row = $this->fetchRow()) {
      $data[$row[$this->groupByColumn]]['label'] = $row[$this->labelColumn];
      $data[$row[$this->groupByColumn]]['months'][$row['month']]
        = $row['COUNT(*)'];
    }

    if ($data) {
      uasort($data, array($this, 'sort'));
    }

    return $data;
  }

  protected function addDefaultSelectsAndJoins()
  {
    $this->selects[] = "SUBSTR($this->tableName.timestamp, 1, 7) AS month";
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'library_id';

    if ($this->table->hasColumn('host')) {
      $this->selects[] = "$this->tableName.host";
    }

    $libraryTableName = $this->getTableName('Library');

    $this->joins[] = "$libraryTableName ON "
      . "{$this->table->getTableName()}.library_id = $libraryTableName.id";

    if (isset($this->params[':database_id'])) {
      $databaseTableName = $this->getTableName('Database');

      $this->selects[] = "$databaseTableName.title";
      $this->joins[] = "$databaseTableName ON "
        . "{$this->table->getTableName()}.database_id = $databaseTableName.id";
    }
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

