<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_DatabaseTest extends sfPHPUnitBaseTestCase
{
  public function testGetLibraryIds_Has_ReturnsExpected()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('A Sorter');
      
    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $this->assertEquals(array($library->getId()), $database->getLibraryIds());
  }

  public function testGetLibraryIds_NotHas_ReturnsEmpty()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Loner');
      
    $this->assertEmpty($database->getLibraryIds()); 
  }
}

