<?php

abstract class ReportSqlQuery
{
  /**
   * @var Doctrine_Table
   */
  protected $table;
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
  protected $groupByColumn;
  /**
   * @var PDOStatement
   */
  protected $pdoStatement;

  /**
   * @param string $string
   */
  protected function sanitize($string)
  {
    return preg_replace('/[^A-Za-z0-9_]/', '', $string);
  }

  /**
   * @param array $filters
   */
  protected function applyTimeFilters(array $filters)
  {
    if (isset($filters['from'])) {
      $this->params[':from'] = $filters['from'];
      $this->wheres[] = 'month >= :from';
    }

    if (isset($filters['to'])) {
      $this->params[':to'] = $filters['to'];
      $this->wheres[] = 'month <= :to';
    }
  }
  
  /**
   * @return string
   */
  protected function getSql()
  {
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

    $this->pdoStatement = Doctrine_Manager::getInstance()
      ->getCurrentConnection()->getDbh()->prepare($this->getSql());

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

