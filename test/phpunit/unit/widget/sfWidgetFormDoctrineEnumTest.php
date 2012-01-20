<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_sfWidgetFormDoctrineEnumTest extends sfPHPUnitBaseTestCase
{
  public function testGetChoices_NotNullTrue_ExpectedChoiceCount()
  {
    $table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => true, 
      )));

    $table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $table,
      'column' => 'column',
    ));

    $this->assertCount(3, $widget->getChoices());
  }

  public function testGetChoices_NotNullTrue_NoEmptyChoice()
  {
    $table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => true, 
      )));

    $table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $table,
      'column' => 'column',
    ));

    $this->assertFalse(array_search('', $widget->getChoices()));
  }

  public function testGetChoices_NotNullFalse_ExpectedChoiceCount()
  {
    $table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => false,
      )));

    $table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $table,
      'column' => 'column',
    ));

    $this->assertCount(4, $widget->getChoices());
  }

  public function testGetChoices_NotNullFalse_EmptyChoiceFirst()
  {
    $table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => false,
      )));

    $table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $table,
      'column' => 'column',
    ));

    $choices = $widget->getChoices();

    $this->assertEquals('', array_shift($choices));
  }

  public function testGetChoices_NotNullUnspecified_ExpectedChoiceCount()
  {
    $table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $table,
      'column' => 'column',
    ));

    $this->assertCount(4, $widget->getChoices());
  }

  public function testGetChoices_NotNullUnspecified_EmptyChoiceFirst()
  {
    $table = $this->getMockBuilder('Doctrine_Table')
      ->disableOriginalConstructor()
      ->getMock();

    $table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $table->expects($this->any())
      ->method('getEnumValues')
      ->will($this->returnValue(array('1', '2', '3')));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $table,
      'column' => 'column',
    ));

    $choices = $widget->getChoices();

    $this->assertEquals('', array_shift($choices));
  }
}

