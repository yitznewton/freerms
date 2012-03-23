<?php
require_once dirname(__FILE__).'/../FunctionalTestCase.php';

class ReportsFunctionalTestCase extends FunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('reports', 'test', true);
  }

  protected function getApplication()
  {
    return 'reports';
  }
}

