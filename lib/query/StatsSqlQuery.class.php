<?php

class StatsSqlQuery extends ReportSqlQuery
{
  /**
   * @param string $groupByColumn
   * @param string $groupByTable Relation grouped by; may be null
   * @param string $labelColumn To use as table header
   * @return array Sorted array of results
   */
  public function get($groupByColumn, $groupByTable, $labelColumn)
  {
    $libraryTableName = $this->getTableName('Library');

    $labelColumn = $this->sanitize($labelColumn);
    $this->groupByColumn = $this->sanitize($groupByColumn);

    if ($groupByTable) {
      $foreignTableName = $this->getTableName($groupByTable);

      $this->selects[] = "f.$labelColumn";
      $this->joins[] = "$foreignTableName f ON t.$this->groupByColumn = f.id";
    }
    else {
      $this->selects[] = $labelColumn;
    }

    $this->selects[] = 'SUBSTR(t.timestamp, 1, 7) AS month';
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'library_id';
    $this->selects[] = $this->groupByColumn;

    if ($this->table->hasColumn('host')) {
      $this->selects[] = 't.host';
    }

    $this->joins[] = "$libraryTableName l ON t.library_id = l.id";

    if (isset($this->params[':database_id'])) {
      $databaseTableName = $this->getTableName('Database');

      $this->selects[] = 'd.title';
      $this->joins[] = "$databaseTableName d ON t.database_id = d.id";
    }

    $this->execute();

    $data = array();

    while ($row = $this->fetchRow()) {
      $data[$row[$this->groupByColumn]]['label'] = $row[$labelColumn];
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

