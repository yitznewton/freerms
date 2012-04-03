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
  public function testGetSql_UnsafeFilterKey_Throws()
  {
    $query = new ShareSqlQuery($this->table, 'is_mobile', $this->pdo);
    $query->addFilters(array('unsafe; DELETE FROM user;' => 'foobar'));
  }

  public function testGetSql_ExpectedSql()
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

  public function testGetSql_TimestampFilter_ExpectedSql()
  {
    $query = new ShareSqlQuery($this->table, 'is_mobile', $this->pdo);

    $query->addFilters(array(
      'library_id' => 1,
      'timestamp' => array(
        'from' => '2011-01',
        'to'   => '2011-12',
      ),
    ));

    $method = new ReflectionMethod($query, 'getSql');
    $method->setAccessible(true);

    $this->assertRegExp('/SUBSTR\(timestamp, 1, 7\) <=/', $method->invoke($query));
  }
}

