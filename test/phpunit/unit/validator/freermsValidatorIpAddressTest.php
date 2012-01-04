<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_freermsValidatorIpAddressTest extends sfPHPUnitBaseTestCase
{
  public function testClean_ValidIp_NotThrows()
  {
    $validator = new freermsValidatorIpAddress();
    $this->assertEquals('192.168.65.12', $validator->clean('192.168.65.12'));
  }

  /**
   * @expectedException sfValidatorError
   */
  public function testClean_InvalidIp_Throws()
  {
    $validator = new freermsValidatorIpAddress();
    $validator->clean('1922.168.65.12');
  }
}

