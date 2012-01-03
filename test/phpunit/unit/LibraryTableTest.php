<?php
require_once dirname(__FILE__).'/DoctrineTableTestCase.php';

class unit_LibraryTableTest extends DoctrineTableTestCase
{
  public function testfindOneByIpAddress_Exists_ReturnsLibrary()
  {
    $this->assertInstanceOf('Library',
      Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.168.100.100'));
  }

  public function testfindOneByIpAddress_NotExists_ReturnsNull()
  {
    $this->assertNull(Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.100.100.100'));
  }
}

