<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_IpRangeTest extends sfPHPUnitBaseTestCase
{
  public function testSetStartIp_ValidIp_SetsStartIpSort()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('92.245.1.1');
    $this->assertEquals('092245001001', $ipRange->getStartIpSort(),
      'IpRange::setStartIp() sets start_ip_sort correctly');
  }

  public function testSetEndIp_ValidIp_SetsEndIpSort()
  {
    $ipRange = new IpRange();
    $ipRange->setEndIp('92.245.1.1');
    $this->assertEquals('092245001001', $ipRange->getEndIpSort(),
      'IpRange::setEndIp() sets end_ip_sort correctly');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testSetStartIp_InvalidIp_ThrowsException()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('292.245.1.1');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testSetEndIp_InvalidIp_ThrowsException()
  {
    $ipRange = new IpRange();
    $ipRange->setEndIp('292.245.1.1');
  }

  public function testSetEndIpForSingle_Single_SetsEndIp()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.245.1.1');

    $this->assertEquals('192.245.1.1', $ipRange->getEndIp(),
      'IpRange::endIp set on save of single IP address');
  }

  public function testSetEndIpForSingle_Range_NotSetsEndIp()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.245.1.1');
    $ipRange->setEndIp('192.245.1.2');

    $this->assertEquals('192.245.1.2', $ipRange->getEndIp(),
      'IpRange::endIp not set on persist of IP address range');
  }
}

