<?php

class StatsQuery extends ReportSqlQuery
{
  /**
   * @param Doctrine_Table $table
   */
  public function __construct(Doctrine_Table $table)
  {
    $this->table = $table;
  }

  /**
   * @param string $groupByColumn
   * @param string $groupByTable Relation grouped by; may be null
   * @param string $labelColumn To use as table header
   * @param array $filters
   * @return array Sorted array of results
   */
  public function get($groupByColumn, $groupByTable, $labelColumn, array $filters)
  {
    $params = array();

    $libraryTableName = Doctrine_Core::getTable('Library')->getTableName();

    $labelColumn = $this->sanitize($labelColumn);
    $this->groupByColumn = $this->sanitize($groupByColumn);

    if ($groupByTable) {
      $foreignTableName = Doctrine_Core::getTable($groupByTable)
        ->getTableName();

      $this->selects[] = "f.$labelColumn";
      $this->joins[] = "$foreignTableName f ON t.$this->groupByColumn = f.id";
    }
    else {
      $this->selects[] = $labelColumn;
    }

    $this->joins[] = "$libraryTableName l ON t.library_id = l.id";

    if (isset($filters['timestamp']['from'])) {
      $this->wheres[] = 'SUBSTR(t.timestamp, 1, 7) >= :from';
      $params[':from'] = $filters['timestamp']['from'];
    }

    if (isset($filters['timestamp']['to'])) {
      $this->wheres[] = 'SUBSTR(t.timestamp, 1, 7) <= :to';
      $params[':to'] = $filters['timestamp']['to'];
    }

    if (isset($filters['timestamp'])) {
      unset($filters['timestamp']);
    }

    foreach ($filters as $key => $value) {
      $key = $this->sanitize($key);
      $this->wheres[] = "$key = :$key";
      $params[":$key"] = $value;
    }

    $this->selects[] = 'SUBSTR(t.timestamp, 1, 7) as month';
    $this->selects[] = 'COUNT(*)';
    $this->selects[] = 'library_id';
    $this->selects[] = $this->groupByColumn;

    if ($this->table->hasColumn('host')) {
      $this->selects[] = 't.host';
    }

    if (isset($filters['database_id'])) {
      $databaseTableName = Doctrine_Core::getTable('Database')
        ->getTableName();

      $this->selects[] = 'd.title';
      $this->joins[] = "$databaseTableName d ON t.database_id = d.id";
    }

    $this->execute($params);

    $data = array();

    while ($row = $this->fetchRow()) {
      $data[$row[$this->groupByColumn]]['label'] = $row[$labelColumn];
      $data[$row[$this->groupByColumn]]['months'][$row['month']] = $row['COUNT(*)'];
    }

    if ($data) {
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
    }

    return $data;
  }
}

