<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_freermsSfGuardUserTest extends DoctrineTestCase
{
  public function setUp()
  {
    parent::setUp();

    $this->dispatcher = $this->getMock('sfEventDispatcher');
    $this->storage    = $this->getMock('sfStorage');
  }

  public function testGetLibraryIds_HasTwoLibraryAffiliations_ReturnsIds()
  {
    $securityUser = new freermsSfGuardUser($this->dispatcher, $this->storage);
    
    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrariestcstcny');

    $securityUser->signIn($user);

    $libraryIds = $securityUser->getLibraryIds();

    if (count($libraryIds) != 2) {
      $this->fail();
    }

    $library0 = Doctrine_Core::getTable('Library')
      ->find($libraryIds[0]);

    $library1 = Doctrine_Core::getTable('Library')
      ->find($libraryIds[1]);

    if (!$library0 || !$library1) {
      $this->fail();
    }

    $values = array($library0->getCode(), $library1->getCode());
    sort($values);

    $this->assertEquals(array('TCNY', 'TCS'), $values);
  }

  public function testGetLibraryIds_HasLibraryAffiliation_ReturnsId()
  {
    $securityUser = new freermsSfGuardUser($this->dispatcher, $this->storage);
    
    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $securityUser->signIn($user);

    $libraryIds = $securityUser->getLibraryIds();

    $library = Doctrine_Core::getTable('Library')
      ->find($libraryIds[0]);

    if (!$library) {
      $this->fail();
    }

    $this->assertEquals('TCS', $library->getCode());
  }

  public function testGetLibraryIds_NoLibraryAffiliation_ReturnsEmpty()
  {
    $securityUser = new freermsSfGuardUser($this->dispatcher, $this->storage);
    
    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('nolibrary');

    $securityUser->signIn($user);

    $this->assertEmpty($securityUser->getLibraryIds());
  }
}

