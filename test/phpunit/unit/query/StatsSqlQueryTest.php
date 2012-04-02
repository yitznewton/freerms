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
  public function testGetSql_UnsafeLabelColumn_Throws()
  {
    $this->query->setLabelColumn('column; DELETE FROM user;');
  }

  /**
   * @expectedException RuntimeException
   */
  public function testGetSql_UnsafeFilterKey_Throws()
  {
    $this->query->addFilters(array('column; DELETE FROM user;' => 1));
  }

  public function testGetSql_DatabaseUsage_ExpectedSql()
  {
    $this->table->expects($this->any())
      ->method('hasColumn')
      ->will($this->returnCallback(function($name) {
        switch ($name) {
          case 'database_id':
            return true;

          default:
            return null;
        }
      }));

    $this->query->setGroupBy('library_id', 'Library');
    $this->query->setLabelColumn('code', 'Library');
    $this->query->addFilters(array('database_id' => 1));

    $method = new ReflectionMethod($this->query, 'getSql');
    $method->setAccessible(true);

    $this->assertEquals(
      'SELECT library_id, library.code, SUBSTR(table_name.timestamp, 1, 7) '
      . 'AS month, COUNT(*), freerms_database.title '
      . 'FROM table_name '
      . 'JOIN library ON table_name.library_id = library.id, '
      . 'freerms_database ON table_name.database_id = freerms_database.id '
      . 'WHERE database_id = :database_id '
      . 'GROUP BY table_name.library_id, month ', 
      $method->invoke($this->query)
    );
  }

  public function testGetSql_UrlUsage_ExpectedSql()
  {
    $this->table->expects($this->any())
      ->method('hasColumn')
      ->will($this->returnCallback(function($name) {
        switch ($name) {
          case 'database_id':
            return false;

          default:
            return null;
        }
      }));

    $this->query->setGroupBy('library_id', 'Library');
    $this->query->setLabelColumn('host');
    $this->query->addFilters(array('library_id' => 1));

    $method = new ReflectionMethod($this->query, 'getSql');
    $method->setAccessible(true);

    $this->assertEquals(
      'SELECT library_id, table_name.host, SUBSTR(table_name.timestamp, 1, 7) '
      . 'AS month, COUNT(*) '
      . 'FROM table_name '
      . 'JOIN library ON table_name.library_id = library.id '
      . 'WHERE library_id = :library_id '
      . 'GROUP BY table_name.library_id, month ', 
      $method->invoke($this->query)
    );
  }

  public function testGetSql_DatabaseUsageByLibrary_SelectsDatabaseTitle()
  {
    $this->table->expects($this->any())
      ->method('hasColumn')
      ->will($this->returnCallback(function($name) {
        switch ($name) {
          case 'database_id':
            return true;

          default:
            return null;
        }
      }));

    $this->query->setGroupBy('library_id', 'Library');
    $this->query->setLabelColumn('code', 'Library');
    $this->query->addFilters(array('library_id' => 1));

    $method = new ReflectionMethod($this->query, 'getSql');
    $method->setAccessible(true);

    $pattern = '/freerms_database ON table_name.database_id '
               . '= freerms_database.id/';

    $this->assertRegExp($pattern, $method->invoke($this->query));
  }
}

