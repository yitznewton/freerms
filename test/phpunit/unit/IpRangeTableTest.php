<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/DoctrineTableTestCase.php';

class unit_IpRangeTableTest extends DoctrineTableTestCase
{
  public static function setUpBeforeClass()
  {
    new sfDatabaseManager(
      ProjectConfiguration::getApplicationConfiguration('admin', 'test', true));
  }

  public function setUp()
  {
    $doctrineInsert = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineInsert->run(array('test/data/fixtures'), array("--env=test"));
  }

  protected function getTable()
  {
    return Doctrine_Core::getTable('IpRange');
  }

  public function testFindIntersecting_MatchesTwo_CorrectOrder()
  {
    $ipRange = new IpRange();
    $ipRange->setStartIp('192.167.1.1');
    $ipRange->setEndIp('192.168.200.1');

    $this->assertEquals('192.167.100.1', $this->getTable()
      ->findIntersecting($ipRange)->getFirst()->getStartIp());
  }

  public function testFindIntersecting_Existing_NotMatchSelf()
  {
    $ipRange = Doctrine_Core::getTable('IpRange')->findAll()->getFirst();

    $this->assertEquals(0, $this->getTable()
      ->findIntersecting($ipRange)->count());
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

  public function testFindByIpSegment_IncludedSegment_ReturnsIpRange()
  {
    $this->assertEquals(1, $this->getTable()
      ->findByIpSegment('192.168')->count());
  }

  public function testFindByIpSegment_NotIncludedSegment_ReturnsEmpty()
  {
    $this->assertEquals(0, $this->getTable()
      ->findByIpSegment('192.245')->count());
  }
}

