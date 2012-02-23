<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_freermsValidatorIpRangeTest extends DoctrineTestCase
{
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

  public function testClean_InactiveIntersectingRange_NotThrows()
  {
    $validator = new freermsValidatorIpRange();

    $values = array(
      'start_ip' => '192.168.100.1',
      'end_ip' => '192.168.100.1',
      'is_active' => '0',
      'is_excluded' => '0',
      'note' => '',
    );

    $this->assertEquals($values, $validator->clean($values));
  }

  public function testClean_ExcludedIntersectingRange_NotThrows()
  {
    $validator = new freermsValidatorIpRange();

    $values = array(
      'start_ip' => '192.168.100.1',
      'end_ip' => '192.168.100.1',
      'is_active' => '1',
      'is_excluded' => '1',
      'note' => '',
    );

    $this->assertEquals($values, $validator->clean($values));
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

