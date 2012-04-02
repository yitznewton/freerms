<?php
require_once dirname(__FILE__).'/ReportSqlQueryTestCase.php';

class unit_ShareSqlQueryTest extends ReportSqlQueryTestCase
{
  /**
   * @expectedException RuntimeException
   */
  public function testConstruct_UnsafeShareColumn_Throws()
  {
    $query = new ShareSqlQuery($this->table, 'column; DELETE FROM user;',
      $this->pdo);
  }

  /**
   * @expectedException RuntimeException
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
      'SELECT table_name.is_mobile, COUNT(*), SUBSTR(table_name.timestamp, 1, 7) AS month '
      . 'FROM table_name WHERE library_id = :library_id '
      . 'GROUP BY table_name.is_mobile ',
      $method->invoke($query)
    );
  }
}

