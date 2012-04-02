<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class ReportSqlQueryTest extends sfPHPUnitBaseTestCase
{
  public function setUp()
  {
    parent::setUp();

    $this->table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $this->table->expects($this->any())
      ->method('getTableName')
      ->will($this->returnValue('table_name'));

    $this->pdo = $this->getMockBuilder('StubPDO')
      ->disableOriginalConstructor()
      ->getMock();

  }
}

class StubPDO extends PDO
{
  public function __construct() {}
}

