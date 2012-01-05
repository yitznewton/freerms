<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';

class unit_DatabaseTableTest extends DoctrineTestCase
{
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

