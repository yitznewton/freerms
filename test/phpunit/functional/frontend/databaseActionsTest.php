<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class functional_frontend_databaseActionsTest extends sfPHPUnitBaseFunctionalTestCase
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

  public function testDefault_NoArgsOnsite_GetsIndex()
  {
    $browser = new sfBrowser(null, '192.168.100.100');
    $test = new sfTestFunctional($browser, $this->getTest());

    $test->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('h2', '/Databases/')->
      end()
    ;
  }

  public function testDefault_WithSubjectOnsite_GetsRightDatabase()
  {
    $browser = new sfBrowser(null, '192.168.100.100');
    $test = new sfTestFunctional($browser, $this->getTest());

    $test->
      get('/?subject=health-sciences')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('h2', '/Databases/')->
      end()
    ;
  }
}

