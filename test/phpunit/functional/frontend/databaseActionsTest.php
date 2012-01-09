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

  protected function getTester($ip)
  {
    $browser = new sfBrowser(null, $ip);

    return new sfTestFunctional($browser, $this->getTest());
  }

  public function testIndex_NoArgsOnsite_GetsIndex()
  {
    $this->getTester('192.168.100.100')->
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

  public function testIndex_NoArgsOffsite_Gets401()
  {
    $this->getTester('192.168.1.1')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(401)->
      end()
    ;
  }

  public function testIndex_WithSubjectOnsite_GetsRightDatabase()
  {
    $this->getTester('192.168.100.100')->
      get('/?subject=health-sciences')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured', '/ProQuest/')->
      end()
    ;
  }

  public function testIndex_Onsite_GetsCorrectDatabaseCount()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.databases li', true, array('count' => 4))->
      end()
    ;
  }

  public function testIndex_Onsite_SubjectWidgetCorrectCount()
  {
    $this->getTester('192.167.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('#subject-select option', true, array('count' => 2))->
      end()
    ;
  }

  public function testIndex_NoFeaturedSubject_DisplayGeneralFeatured()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured li', true, array('count' => 2))->
      end()
    ;
  }

  public function testIndex_WithUnfeaturedSubjectOnsite_NotDisplayFeatured()
  {
    $this->getTester('192.167.100.100')->
      get('/?subject=doesnt-exist')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured', false)->
      end()
    ;
  }
}

