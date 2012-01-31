<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class AccessTestCase extends sfPHPUnitBaseTestCase
{
  public function setUp()
  {
    $this->configuration = ProjectConfiguration::getApplicationConfiguration(
      'frontend', 'test', false);

    $this->affiliation = $this->getMockBuilder('freermsUserAffiliation')
      ->disableOriginalConstructor()
      ->getMock();
  }
}

