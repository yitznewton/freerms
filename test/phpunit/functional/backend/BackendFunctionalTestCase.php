<?php
require_once dirname(__FILE__).'/../FunctionalTestCase.php';

class BackendFunctionalTestCase extends FunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'test', true);
  }

  protected function getApplication()
  {
    return 'backend';
  }
}

