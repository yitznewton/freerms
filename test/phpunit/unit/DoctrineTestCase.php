<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class DoctrineTestCase extends sfPHPUnitBaseTestCase
{
  public static function setUpBeforeClass()
  {
    new sfDatabaseManager(
      ProjectConfiguration::getApplicationConfiguration('admin', 'test', true));
  }

  public function setUp()
  {
    $doctrineInsert = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineInsert->run(array('test/data/fixtures'), array("--env=test"));
  }
}

