<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_IpRangeTableTest extends sfPHPUnitBaseTestCase
{
  public static function setUpBeforeClass()
  {
    new sfDatabaseManager(
      ProjectConfiguration::getApplicationConfiguration('admin', 'test', true));

    Doctrine_Core::getTable('IpRange')->createQuery()->delete()->execute();

    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.100.1');
    $ipRange->setEndIp('192.168.199.255');
    $ipRange->save();
  }

  protected function getTable()
  {
    return Doctrine_Core::getTable('IpRange');
  }

  public function testFindIntersecting_RangeWithin_ReturnsIpRange()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.150.1');
    $ipRange->setEndIp('192.168.160.1');

    $this->assertEquals(1, $this->getTable()
      ->findIntersecting($ipRange)->count());
  }

  public function testFindIntersecting_RangeSurrounding_ReturnsIpRange()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.50.1');
    $ipRange->setEndIp('192.168.240.1');

    $this->assertEquals(1, $this->getTable()
      ->findIntersecting($ipRange)->count());
  }

  public function testFindIntersecting_RangeBelow_ReturnsEmpty()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.50.1');
    $ipRange->setEndIp('192.168.60.1');

    $this->assertEquals(0, $this->getTable()
      ->findIntersecting($ipRange)->count());
  }

  public function testFindIntersecting_RangeAbove_ReturnsEmpty()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.220.1');
    $ipRange->setEndIp('192.168.230.1');

    $this->assertEquals(0, $this->getTable()
      ->findIntersecting($ipRange)->count());
  }

  public function testFindIntersecting_RangeBottom_ReturnsIpRange()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.80.1');
    $ipRange->setEndIp('192.168.100.1');

    $this->assertEquals(1, $this->getTable()
      ->findIntersecting($ipRange)->count());
  }

  public function testFindIntersecting_RangeTop_ReturnsIpRange()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.168.199.255');
    $ipRange->setEndIp('192.168.220.1');

    $this->assertEquals(1, $this->getTable()
      ->findIntersecting($ipRange)->count());
  }
}

