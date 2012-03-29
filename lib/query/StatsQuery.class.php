<?php

class StatsQuery extends ReportSqlQuery
{
  /**
   * @var Doctrine_Table
   */
  protected $table;

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
    $selects = array();
    $joins = array();
    $wheres = array();
    $params = array();

    $tableName = $this->table->getTableName();

    $libraryTableName = Doctrine_Core::getTable('Library')->getTableName();

    $labelColumn = $this->sanitize($labelColumn);
    $groupByColumn = $this->sanitize($groupByColumn);

    if ($groupByTable) {
      $foreignTableName = Doctrine_Core::getTable($groupByTable)
        ->getTableName();

      $selects[] = "f.$labelColumn";
      $joins[] = "$foreignTableName f ON t.$groupByColumn = f.id";
    }
    else {
      $selects[] = $labelColumn;
    }

    $joins[] = "$libraryTableName l ON t.library_id = l.id";

    if (isset($filters['timestamp']['from'])) {
      $wheres[] = 'SUBSTR(t.timestamp, 1, 7) >= :from';
      $params[':from'] = $filters['timestamp']['from'];
    }

    if (isset($filters['timestamp']['to'])) {
      $wheres[] = 'SUBSTR(t.timestamp, 1, 7) <= :to';
      $params[':to'] = $filters['timestamp']['to'];
    }

    if (isset($filters['timestamp'])) {
      unset($filters['timestamp']);
    }

    foreach ($filters as $key => $value) {
      $key = $this->sanitize($key);
      $wheres[] = "$key = :$key";
      $params[":$key"] = $value;
    }

    $selects[] = 'SUBSTR(t.timestamp, 1, 7) as month';
    $selects[] = 'COUNT(*)';
    $selects[] = 'library_id';
    $selects[] = $groupByColumn;

    if ($this->table->hasColumn('host')) {
      $selects[] = 't.host';
    }

    if (isset($filters['database_id'])) {
      $databaseTableName = Doctrine_Core::getTable('Database')
        ->getTableName();

      $selectColumns[] = 'd.title';
      $joins[] = "$databaseTableName d ON t.database_id = d.id";
    }

    $q = 'SELECT '
         . implode(', ', $selects) . ' '
         . "FROM $tableName t "
         . 'JOIN '
         . implode(', ', $joins) . ' '
         ;


    if ($wheres) {
      $q .= 'WHERE ' . implode(' AND ', $wheres) . ' ';
    }

    $q .= "GROUP BY t.$groupByColumn, month ";

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->prepare($q);

    $st->execute($params);

    $data = array();

    while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
      $data[$row[$groupByColumn]]['label'] = $row[$labelColumn];
      $data[$row[$groupByColumn]]['months'][$row['month']] = $row['COUNT(*)'];
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

