<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_sfValidatorDoctrineEnumTest extends sfPHPUnitBaseTestCase
{
  public function setUp()
  {
    $this->table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $this->table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));
  }

  /**
   * @expectedException sfValidatorError
   */
  public function testClean_InvalidOption_ThrowsException()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $validator = new sfValidatorDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $validator->clean('4');
  }

  public function testClean_ValidOption_ReturnsValue()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $validator = new sfValidatorDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertEquals('3', $validator->clean('3'));
  }

  /**
   * @expectedException sfValidatorError
   */
  public function testClean_EmptyStringNotNullTrue_ThrowsException()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => true,
      )));

    $validator = new sfValidatorDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $validator->clean('');
  }

  public function testClean_EmptyStringNotNullFalse_ReturnsValue()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => false,
      )));

    $validator = new sfValidatorDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertEquals('', $validator->clean(''));
  }

  public function testClean_EmptyStringNotNullUnspecified_ReturnsValue()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $validator = new sfValidatorDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertEquals('', $validator->clean(''));
  }
}

