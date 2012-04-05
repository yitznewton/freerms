<?php
require_once dirname(__FILE__).'/../FunctionalTestCase.php';

class ReportsFunctionalTestCase extends FunctionalTestCase
{
  public function setUp()
  {
    parent::setUp();

    ini_set('memory_limit', '275M');

    $configuration = ProjectConfiguration::getApplicationConfiguration('reports', 'test', true);
    $usageGenerator= new generateUsageDataTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $usageGenerator->run(array(1000), array('--env=test'));
  }

  protected function getApplication()
  {
    return 'reports';
  }
}

