<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_freermsValidatorIpRangeTest extends sfPHPUnitBaseTestCase
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

  public function testClean_InvertedRange_Throws()
  {
    $validator = new freermsValidatorIpRange();

    $values = array(
      'start_ip' => '192.168.56.56',
      'end_ip'   => '192.168.1.1',
      'is_active' => '1',
      'is_excluded' => '0',
      'note' => '',
    );

    try {
      $validator->clean($values);
    }
    catch(sfValidatorError $e) {
    }

    $this->assertEquals('inverted', $e->getCode());
  }

  public function testClean_IntersectingRange_Throws()
  {
    $validator = new freermsValidatorIpRange();

    $values = array(
      'start_ip' => '192.168.100.1',
      'end_ip' => '192.168.100.1',
      'is_active' => '1',
      'is_excluded' => '0',
      'note' => '',
    );

    try {
      $validator->clean($values);
    }
    catch(sfValidatorError $e) {
    }

    $this->assertEquals('conflicting', $e->getCode());
  }

  public function testClean_EmptyEndIp_SetsEndIp()
  {
    $validator = new freermsValidatorIpRange();

    $values = array(
      'start_ip' => '192.168.56.56',
      'end_ip'   => '',
      'is_active' => '1',
      'is_excluded' => '',
      'note' => '',
    );

    $cleanValues = $validator->clean($values);

    $this->assertEquals('192.168.56.56', $cleanValues['end_ip']);
  }
}

