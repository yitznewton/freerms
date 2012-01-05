<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_DatabaseTableTest extends DoctrineTestCase
{
  public function testFindByLibrary_ReturnsExpectedFirst()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $this->assertEquals('EBSCO', $table->findByLibrary($library)
      ->getFirst()->getTitle());
  }

  public function testFindByLibrary_NotReturnsHidden()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $databases = $table->findByLibrary($library);

    foreach ($databases as $database) {
      if ($database->getIsHidden()) {
        $this->fail();
      }
    }
  }

  public function testFindFeatured_NotReturnsHidden()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('health-sciences');

    $databases = $table->findFeaturedByLibraryIdsAndSubject(
      array($library->getId()), $subject);

    foreach ($databases as $database) {
      if ($database->getIsHidden()) {
        $this->fail();
      }
    }
  }

  public function testFindFeatured_ReturnsDoctrineCollection()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('health-sciences');

    $this->assertInstanceOf('Doctrine_Collection',
      $table->findFeaturedByLibraryIdsAndSubject(
        array($library->getId()), $subject));
  }

  public function testFindFeatured_ReturnsExpectedDatabaseFirst()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('health-sciences');

    $featured = $table->findFeaturedByLibraryIdsAndSubject(
      array($library->getId()), $subject);

    $this->assertEquals('ProQuest', $featured[0]->getTitle());
  }

  public function testFindFeatured_DoesNotReturnUnfeatured()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('health-sciences');

    $featuredDatabases = $table->findFeaturedByLibraryIdsAndSubject(
      array($library->getId()), $subject);

    foreach ($featuredDatabases as $database) {
      if ($database->getTitle() == 'Unfeatured Medical') {
        $this->fail();
      }
    }
  }
}

