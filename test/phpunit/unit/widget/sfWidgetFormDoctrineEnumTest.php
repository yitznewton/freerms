<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_sfWidgetFormDoctrineEnumTest extends sfPHPUnitBaseTestCase
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

  public function testGetChoices_NotNullTrue_ExpectedChoiceCount()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => true, 
      )));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertCount(3, $widget->getChoices());
  }

  public function testGetChoices_NotNullTrue_NoEmptyChoice()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => true, 
      )));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertFalse(array_search('', $widget->getChoices()));
  }

  public function testGetChoices_NotNullFalse_ExpectedChoiceCount()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => false,
      )));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertCount(4, $widget->getChoices());
  }

  public function testGetChoices_NotNullFalse_EmptyChoiceFirst()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
        'notnull' => false,
      )));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $choices = $widget->getChoices();

    $this->assertEquals('', array_shift($choices));
  }

  public function testGetChoices_NotNullUnspecified_ExpectedChoiceCount()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $this->assertCount(4, $widget->getChoices());
  }

  public function testGetChoices_NotNullUnspecified_EmptyChoiceFirst()
  {
    $this->table->expects($this->any())
      ->method('getColumnDefinition')
      ->will($this->returnValue(array(
      )));

    $widget = new sfWidgetFormDoctrineEnum(array(
      'table' => $this->table,
      'column' => 'column',
    ));

    $choices = $widget->getChoices();

    $this->assertEquals('', array_shift($choices));
  }
}

