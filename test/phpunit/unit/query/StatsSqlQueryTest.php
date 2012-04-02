<?php
require_once dirname(__FILE__).'/ReportSqlQueryTest.php';

class unit_StatsSqlQueryTest extends ReportSqlQueryTest
{
  /**
   * @expectedException
   */
  public function testGet_UnsafeLabelColumn_Throws()
  {
  }

  /**
   * @expectedException
   */
  public function testGet_UnsafeFilterKey_Throws()
  {
  }

  public function testGet_UrlUsage_ExpectedSql()
  {
  }

  public function testGet_DatabaseUsage_ExpectedSql()
  {
  }
}

