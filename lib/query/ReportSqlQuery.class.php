<?php

/**
 * @todo add support for Doctrine profiler
 */
abstract class ReportSqlQuery
{
  /**
   * @var Doctrine_Table
   */
  protected $table;
  /**
   * @var PDO
   */
  protected $pdo;
  /**
   * @var PDOStatement
   */
  protected $pdoStatement;
  /**
   * @var array
   */
  protected $params = array();
  /**
   * @var array string[]
   */
  protected $selects = array();
  /**
   * @var array string[]
   */
  protected $joins = array();
  /**
   * @var array string[]
   */
  protected $wheres = array();
  /**
   * @var string
   */
  protected $labelColumn;
  /**
   * @var string
   */
  protected $groupByColumn;
  /**
   * @var string
   */
  protected $groupByModel;
  /**
   * @var array
   */
  protected $tableNames = array();

  /**
   * @param Doctrine_Table $table
   * @param PDO $pdo
   */
  public function __construct(Doctrine_Table $table, PDO $pdo = null)
  {
    $this->table = $table;
    $this->pdo = $pdo ? $pdo : $this->table->getConnection()->getDbh();
  }

  /**
   * @param array $filters
   */
  public function addFilters(array $filters)
  {
    foreach ($filters as $key => $value) {
      $this->applyFilter($key, $value);
    }
  }

  public function setLabelColumn($column)
  {
    $this->labelColumn = $this->sanitize($column);
  }

  public function setGroupBy($column, $model = null)
  {
    $this->groupByColumn = $this->sanitize($column);
    $this->selects[] = 't.' . $this->groupByColumn;

    if ($model) {
      $this->groupByModel = $model;
    }
  }

  /**
   * @param string $string
   * @return string
   */
  protected function sanitize($string)
  {
    if (preg_match('/[^A-Za-z0-9_]/', $string)) {
      throw new RuntimeException("Unsafe characters in string '$string'");
    }

    return $string;
  }

  protected function applyFilter($key, $value)
  {
    $key = $this->sanitize($key);

    switch ($key) {
      case 'timestamp':
        foreach ($value as $subkey => $subvalue) {
          $this->applyFilter($subkey, $subvalue);
        }
        break;

      case 'from':
        $this->params[":$key"] = $value;
        $this->wheres[] = "month >= :$key";
        break;

      case 'to':
        $this->params[":$key"] = $value;
        $this->wheres[] = "month <= :$key";
        break;

      default:
        $this->wheres[] = "$key = :$key";
        $this->params[":$key"] = $value;
        break;
    }
  }

  protected function addGroupBySelectAndJoin()
  {
    if ($this->groupByModel) {
      $foreignTableName = $this->getTableName($this->groupByModel);
      $this->joins[] = "$foreignTableName f ON t.$this->groupByColumn = f.id";
    }

    if ($this->groupByModel && $this->labelColumn) {
      $this->selects[] = "f.$labelColumn";
    }
    elseif ($this->labelColumn) {
      $this->selects[] = $this->labelColumn;
    }
  }

  /**
   * @param string $model
   * @return string
   */
  protected function getTableName($model)
  {
    return isset($this->tableNames[$model])
      ? $this->tableNames[$model]
      : Doctrine_Core::getTable($model)->getTableName();
  }

  /**
   * Set table names manually for dependency injection
   *
   * @param array $names
   */
  public function setTableNames(array $names)
  {
    foreach ($names as $model => $name) {
      if (!is_string($name)) {
        throw new InvalidArgumentException('Table names must be strings');
      }

      $this->tableNames[$model] = $name;
    }
  }

  /**
   * @return string
   */
  protected function getSql()
  {
    $this->selects = array_unique($this->selects);
    $this->joins   = array_unique($this->joins);
    $this->wheres  = array_unique($this->wheres);

    $sql = 'SELECT '
           . implode(', ', $this->selects) . ' '
           . "FROM {$this->table->getTableName()} t "
           ;

    if ($this->joins) {
      $sql .= 'JOIN ' . implode(', ', $this->joins) . ' ';
    }

    if ($this->wheres) {
      $sql .= 'WHERE ' . implode(' AND ', $this->wheres) . ' ';
    }

    if ($this->groupByColumn) {
      $sql .= "GROUP BY t.$this->groupByColumn, month ";
    }

    return $sql;
  }

  protected function execute()
  {
    if ($this->pdoStatement) {
      throw new RuntimeException('Already executed');
    }

    $this->addGroupBySelectAndJoin();

    $this->pdoStatement = $this->pdo->prepare($this->getSql());
    $this->pdoStatement->execute($this->params);
  }

  /**
   * @return array
   */
  protected function fetchRow()
  {
    if (!$this->pdoStatement) {
      throw new RuntimeException('Not yet executed');
    }

    return $this->pdoStatement->fetch(PDO::FETCH_ASSOC);
  }
}

