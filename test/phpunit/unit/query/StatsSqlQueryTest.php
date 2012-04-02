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
      'SELECT SUBSTR(table_name.timestamp, 1, 7) AS month, COUNT(*), '
      . 'library_id, library.code '
      . 'FROM table_name '
      . 'JOIN library ON table_name.library_id = library.id '
      . 'WHERE database_id = :database_id '
      . 'GROUP BY table_name.library_id, month ', 
      $method->invoke($this->query)
    );
  }

  public function testGet_UrlUsage_ExpectedSql()
  {
    $this->query->setGroupBy('library_id', 'Library');
    $this->query->setLabelColumn('host');
    $this->query->addFilters(array('library_id' => 1));

    $method = new ReflectionMethod($this->query, 'getSql');
    $method->setAccessible(true);

    $this->assertEquals(
      'SELECT SUBSTR(table_name.timestamp, 1, 7) AS month, COUNT(*), '
      . 'library_id, table_name.host '
      . 'FROM table_name '
      . 'JOIN library ON table_name.library_id = library.id '
      . 'WHERE library_id = :library_id '
      . 'GROUP BY table_name.library_id, month ', 
      $method->invoke($this->query)
    );
  }
}

