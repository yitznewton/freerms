<?php
require_once dirname(__FILE__).'/ReportSqlQueryTestCase.php';

class unit_StatsSqlQueryTest extends ReportSqlQueryTestCase
{
  /**
   * @expectedException RuntimeException
   */
  public function testGet_UnsafeLabelColumn_Throws()
  {
    $statsQuery = new StatsSqlQuery($this->table, $this->pdo);
    $statsQuery->setLabelColumn('column; DELETE FROM user;');
  }

  /**
   * @expectedException RuntimeException
   */
  public function testGet_UnsafeFilterKey_Throws()
  {
    $statsQuery = new StatsSqlQuery($this->table, $this->pdo);
    $statsQuery->addFilters(array('column; DELETE FROM user;' => 1));
  }

  public function testGet_UrlUsage_ExpectedSql()
  {
  }

  public function testGet_DatabaseUsage_ExpectedSql()
  {
  }
}

