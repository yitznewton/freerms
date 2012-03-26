<?php
require_once dirname(__FILE__).'/../FunctionalTestCase.php';

class ReportsFunctionalTestCase extends FunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('reports', 'test', true);

    $doctrineLoad = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineLoad->run(array('test/data/fixtures'), array("--env=test"));

    $usageGenerator= new generateUsageDataTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $usageGenerator->run(array(1000), array());
  }

  public function setUp()
  {
    sfPHPUnitBaseFunctionalTestCase::setUp();

    // omit loading for every test
  }

  protected function getApplication()
  {
    return 'reports';
  }
}

