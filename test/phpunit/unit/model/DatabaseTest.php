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

  /**
   * @expectsException RuntimeException
   */
  public function testCopy_CalledOnNew_ThrowsException()
  {
    $database = new Database();
    $database->copy(true);
  }

  public function testCopy_HasLibraries()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('A Sorter');
      
    $copy = $database->copy();

    $this->assertEquals($database->getLibraries(), $copy->getLibraries());
  }

  public function testCopy_HasSubjects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');
      
    $copy = $database->copy();

    $this->assertEquals($database->getSubjects(), $copy->getSubjects());
  }

  public function testCopy_SetsIsNew()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');
      
    $copy = $database->copy();

    $this->assertTrue($copy->isNew());
  }

  public function testCopy_UnsetsId()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');
      
    $copy = $database->copy();

    $this->assertNull($copy->getId());
  }

  public function testCopy_UnsetsAltId()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');
      
    $copy = $database->copy();

    $this->assertNull($copy->getAltId());
  }

  public function testGetAdditionalFieldsArray_InvalidYaml_ReturnsNull()
  {
    $database = new Database();

    $database->setAdditionalFields(array('not valid yaml'));

    $this->assertNull($database->getAdditionalFieldsArray());
  }

  public function testGetAdditionalFieldsArray_ValidYaml_ReturnsExpectedArray()
  {
    $database = new Database();

    $database->setAdditionalFields('


this is some:
  - valid
  - yaml, see
    
    ');

    $this->assertEquals(array('this is some'),
      array_keys($database->getAdditionalFieldsArray()));
  }
}

