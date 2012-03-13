<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class DoctrineTestCase extends sfPHPUnitBaseTestCase
{
  public static function setUpBeforeClass()
  {
    new sfDatabaseManager(
      ProjectConfiguration::getApplicationConfiguration('backend', 'test', true));
  }

  public function setUp()
  {
    $doctrineCreateTables = new sfDoctrineCreateModelTables(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineCreateTables->run(array('Library Database'), array("--env=test"));

    $doctrineInsert = new sfDoctrineInsertSqlTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineInsert->run(array(), array("--env=test"));

    $doctrineLoad = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineLoad->run(array('test/data/fixtures'), array("--env=test"));
  }
}

