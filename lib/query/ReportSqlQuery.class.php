<?php

abstract class ReportSqlQuery
{
  /**
   * @var Doctrine_Table
   */
  protected $table;
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

  /**
   * @param array $params
   */
  protected function execute(array $params)
  {
    if ($this->pdoStatement) {
      throw new RuntimeException('Already executed');
    }

    $this->pdoStatement = Doctrine_Manager::getInstance()
      ->getCurrentConnection()->getDbh()->prepare($this->getSql());

    $this->pdoStatement->execute($params);
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

