<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_sfGuardGroupTableTest extends DoctrineTestCase
{
  public function testSyncLibrary_ExistingGroupNewName_UpdatesGroupDescription()
  {
    $library = new Library();
    $library->setCode('TCLA');
    $library->setName('Wassamatta');

    $table = Doctrine_Core::getTable('sfGuardGroup');
    $table->syncLibrary($library);

    $this->assertEquals('Wassamatta',
      $table->findOneByName('TCLA')->getDescription());
  }

  public function testSyncLibrary_NewGroup_Creates()
  {
    $library = new Library();
    $library->setCode('THMED');
    $library->setName('Touro Harlem');

    $table = Doctrine_Core::getTable('sfGuardGroup');
    $table->syncLibrary($library);

    $this->assertEquals('Touro Harlem',
      $table->findOneByName('THMED')->getDescription());
  }
}

