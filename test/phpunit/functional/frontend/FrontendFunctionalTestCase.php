<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class FrontendFunctionalTestCase extends sfPHPUnitBaseFunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    new sfDatabaseManager(
      ProjectConfiguration::getApplicationConfiguration('admin', 'test', true));
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
    return 'frontend';
  }

  protected function getTester($ip)
  {
    $browser = new sfBrowser(null, $ip);

    return new sfTestFunctional($browser, $this->getTest());
  }
}

