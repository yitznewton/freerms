<?php
require_once dirname(__FILE__).'/ReportSqlQueryTestCase.php';

class unit_StatsSqlQueryTest extends ReportSqlQueryTestCase
{
  public function setUp()
  {
    parent::setUp();

    $this->query = new StatsSqlQuery($this->table, $this->pdo);
    $this->query->setTableNames(array(
      'Database' => 'freerms_database',
      'Library'  => 'library',
    ));
  }

  /**
   * @expectedException RuntimeException
   */
  public function testGet_UnsafeLabelColumn_Throws()
  {
    $this->query->setLabelColumn('column; DELETE FROM user;');
  }

  /**
   * @expectedException RuntimeException
   */
  public function testGet_UnsafeFilterKey_Throws()
  {
    $this->query->addFilters(array('column; DELETE FROM user;' => 1));
  }

  public function testGet_DatabaseUsage_ExpectedSql()
  {
    $this->query->setGroupBy('library_id', 'Library');
    $this->query->setLabelColumn('code', 'Library');
    $this->query->addFilters(array('database_id' => 1));

    $method = new ReflectionMethod($this->query, 'getSql');
    $method->setAccessible(true);

    $this->assertEquals(
      'SELECT SUBSTR(t.timestamp, 1, 7) AS month, COUNT(*), '
      . 'library_id, library.code '
      . 'FROM table_name t '
      . 'JOIN library l ON t.library_id = l.id '
      . 'WHERE database_id = :database_id '
      . 'GROUP BY t.library_id, month ', 
      $method->invoke($this->query)
    );
  }

  public function testGet_UrlUsage_ExpectedSql()
  {
  }
}

