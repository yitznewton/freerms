<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class FrontendFunctionalTestCase extends sfPHPUnitBaseFunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

    new sfDatabaseManager($configuration);

    $doctrineDrop = new sfDoctrineDropDbTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineDrop->run(array(), array("--no-confirmation","--env=test"));

    $doctrineBuild = new sfDoctrineBuildDbTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineBuild->run(array(), array("--env=test"));

    $doctrineInsert = new sfDoctrineInsertSqlTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineInsert->run(array(), array("--env=test"));

    // frontend decorator templates for testing
    touch(sfConfig::get('sf_apps_dir').'/frontend/templates/test1.php');
    touch(sfConfig::get('sf_apps_dir').'/frontend/templates/test2.php');
  }

  public static function tearDownAfterClass()
  {
    // frontend decorator templates for testing
    unlink(sfConfig::get('sf_apps_dir').'/frontend/templates/test1.php');
    unlink(sfConfig::get('sf_apps_dir').'/frontend/templates/test2.php');
  }

  public function setUp()
  {
    parent::setUp();

    $doctrineLoad = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineLoad->run(array('test/data/fixtures'), array("--env=test"));

    // seems that no fixtures means table untouched; delete manually
    Doctrine_Core::getTable('DatabaseUsage')->findAll()->delete();
    Doctrine_Core::getTable('UrlUsage')->findAll()->delete();
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

  protected function login(sfTestFunctional $tester, $username, $password)
  {
    $csrf = $tester->getResponseDom()->getElementById('signin__csrf_token')
      ->getAttribute('value');

    $tester->post('/guard/login', array('signin' => array(
      'username' => $username,
      'password' => $password,
      '_csrf_token' => $csrf,
    )));

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->followRedirect();

    return $tester;
  }
}

