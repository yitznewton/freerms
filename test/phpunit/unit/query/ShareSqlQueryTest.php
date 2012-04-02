<?php
require_once dirname(__FILE__).'/ReportSqlQueryTest.php';

class unit_ShareSqlQueryTest extends ReportSqlQueryTest
{
  /**
   * @expectedException
   */
  public function testConstruct_UnsafeShareColumn_Throws()
  {
    $query = new ShareSqlQuery($this->table, 'column; DELETE FROM user;',
      $this->pdo);
  }

  /**
   * @expectedException
   */
  public function testGet_UnsafeFilterKey_Throws()
  {
    $query = new ShareSqlQuery($this->table, 'is_mobile', $this->pdo);
    $query->addFilters(array('unsafe; DELETE FROM user;' => 'foobar'));
  }

  public function testGet_ExpectedSql()
  {
    $query = new ShareSqlQuery($this->table, 'is_mobile', $this->pdo);

    $query->addFilters(array('library_id' => 1));

    $method = new ReflectionMethod($query, 'getSql');
    $method->setAccessible(true);

    $this->assertEquals(
      'SELECT t.is_mobile, COUNT(*), SUBSTR(t.timestamp, 1, 7) AS month '
      . 'FROM table_name t WHERE library_id = :library_id '
      . 'GROUP BY t.is_mobile, month ',
      $method->invoke($query)
    );
  }
}

