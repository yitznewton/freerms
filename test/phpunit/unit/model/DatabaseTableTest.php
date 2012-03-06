<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_DatabaseTableTest extends DoctrineTestCase
{
  public function testFindAll_ReturnNotIncludesDeleted()
  {
    $table = Doctrine_Core::getTable('Database');

    foreach ($table->findAll() as $database) {
      if ($database->getDeletedAt()) {
        $this->fail();
      }
    }
  }

  public function testFindByLibraryIdsAndSubject_ReturnsExpectedFirst()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $this->assertEquals('Anded', $table->findByLibraryIdsAndSubject(
      array($library->getId()))->getFirst()->getTitle());
  }

  public function testFindByLibraryIdsAndSubject_NotReturnsHidden()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $databases = $table->findByLibraryIdsAndSubject(array($library->getId()));

    foreach ($databases as $database) {
      if ($database->getIsHidden()) {
        $this->fail();
      }
    }
  }

  public function testFindByLibraryIdsAndSubject_Subject_ReturnsExpectedCount()
  {
    $table = Doctrine_Core::getTable('Database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('psychology');

    $this->assertEquals(1, $table->findByLibraryIdsAndSubject(
      array($library->getId()), $subject)->count());
  }

  public function testFindByLibraryIdsAndSubject_MultipleLibraries_ReturnsExpectedCount()
  {
    $table = Doctrine_Core::getTable('Database');

    $library0 = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $library1 = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $libraryIds = array($library0->getId(), $library1->getId());

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('psychology');

    $this->assertEquals(1, $table->findByLibraryIdsAndSubject(
      $libraryIds, $subject)->count());
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

  public function testFindFeatured_MultipleLibraries_ReturnsDoctrineCollection()
  {
    $table = Doctrine_Core::getTable('Database');

    $library0 = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $library1 = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $libraryIds = array($library0->getId(), $library1->getId());

    $subject = Doctrine_Core::getTable('Subject')
      ->findOneBySlug('health-sciences');

    $this->assertInstanceOf('Doctrine_Collection',
      $table->findFeaturedByLibraryIdsAndSubject($libraryIds, $subject));
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

  public function testFindGeneralFeatured_ReturnsExpectedCount()
  {
    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $this->assertEquals(3, Doctrine_Core::getTable('Database')
      ->findGeneralFeaturedByLibraryIds(array($library->getId()))->count());
  }

  public function testFindGeneralFeatured_MultipleLibraries_ReturnsExpectedCount()
  {
    $library0 = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $library1 = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $libraryIds = array($library0->getId(), $library1->getId());

    $this->assertEquals(3, Doctrine_Core::getTable('Database')
      ->findGeneralFeaturedByLibraryIds($libraryIds)->count());
  }

  public function testFindGeneralFeatured_ReturnsExpectedOrder()
  {
    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $this->assertEquals('Pubmed', Doctrine_Core::getTable('Database')
      ->findGeneralFeaturedByLibraryIds(array($library->getId()))
      ->getFirst()->getTitle());
  }
}

