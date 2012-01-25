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

