<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class BackendFunctionalTestCase extends sfPHPUnitBaseFunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'test', true);

    new sfDatabaseManager($configuration);

    $doctrineDrop = new sfDoctrineDropDbTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineDrop->run(array(), array("--no-confirmation","--env=test"));

    $doctrineBuild = new sfDoctrineBuildDbTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineBuild->run(array(), array("--env=test"));

    $doctrineInsert = new sfDoctrineInsertSqlTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineInsert->run(array(), array("--env=test"));
  }

  public function setUp()
  {
    parent::setUp();

    $doctrineInsert = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineInsert->run(array('test/data/fixtures'), array("--env=test"));
  }

  protected function getApplication()
  {
    return 'backend';
  }

  protected function getTester($ip)
  {
    $browser = new sfBrowser(null, $ip);

    return new sfTestFunctional($browser, $this->getTest());
  }
}

