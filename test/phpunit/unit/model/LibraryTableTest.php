<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_LibraryTableTest extends DoctrineTestCase
{
  public function testFindOneByIpAddress_Exists_ReturnsLibrary()
  {
    $this->assertInstanceOf('Library',
      Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.168.100.100'));
  }

  public function testFindOneByIpAddress_Exists_ReturnsLibraryWithId()
  {
    $this->assertInstanceOf('Library',
      Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.168.100.100'));

    $this->assertInternalType('string',
      Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.168.100.100')
      ->getId());
  }

  public function testFindOneByIpAddress_ExistsActiveAndInactive_ReturnsNull()
  {
    // for some reason this eats up 35M of RAM when using assertNull
    $this->assertEquals(null, Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.167.120.128'));
  }

  public function testFindOneByIpAddress_NotExists_ReturnsNull()
  {
    $this->assertNull(Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.100.100.100'));
  }

  public function testGetCodesForIds_Exists_ReturnsExpected()
  {
    $id = Doctrine_Core::getTable('Library')->findOneByCode('TCNY')->getId();

    $this->assertEquals(array('TCNY'),
      Doctrine_Core::getTable('Library')->getCodesForIds(array($id)));
  }

  public function testGetCodesForIds_NotExists_ReturnsEmpty()
  {
    $this->assertEquals(array(),
      Doctrine_Core::getTable('Library')->getCodesForIds(array(9876)));
  }
}

