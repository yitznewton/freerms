<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_DatabaseTest extends DoctrineTestCase
{
  public function testGetLibraryIds_HasMultiple_ReturnsExpected()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('A Sorter');
      
    $library_tcs = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $library_tcny = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $control = array($library_tcs->getId(), $library_tcny->getId());
    sort($control);

    $test = $database->getLibraryIds();
    sort($test);

    $this->assertEquals($control, $test);
  }

  public function testGetLibraryIds_HasOne_ReturnsExpected()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EBSCO');
      
    $library_tcs = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $this->assertEquals(array($library_tcs->getId()),
      $database->getLibraryIds());
  }

  public function testGetLibraryIds_NotHas_ReturnsEmpty()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Loner');
      
    $this->assertEmpty($database->getLibraryIds()); 
  }
}

