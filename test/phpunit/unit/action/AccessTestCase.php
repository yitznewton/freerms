<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';
require_once __DIR__.'/../../../../apps/frontend/modules/access/lib/exception/accessUnauthorizedException.class.php';

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

