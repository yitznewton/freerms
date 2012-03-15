<?php
require_once dirname(__FILE__).'/../bootstrap/functional.php';

class FunctionalTestCase extends sfPHPUnitBaseFunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

    new sfDatabaseManager($configuration);

    $doctrineDrop = new sfDoctrineDropDbTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineDrop->run(array(), array("--no-confirmation","--env=test"));

    $doctrineBuild = new sfDoctrineBuildDbTask($configuration->getEventDispatcher(), new sfAnsiColorFormatter());
    $doctrineBuild->run(array(), array("--env=test"));

    $doctrineInsert = new sfDoctrineInsertSqlTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineInsert->run(array(), array("--env=test"));
  }

  public function setUp()
  {
    parent::setUp();

    $doctrineCreateTables = new sfDoctrineCreateModelTables(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineCreateTables->run(array('Library Database'), array("--env=test"));

    $doctrineLoad = new sfDoctrineDataLoadTask(
      ProjectConfiguration::getActive()->getEventDispatcher(),
      new sfAnsiColorFormatter());

    $doctrineLoad->run(array('test/data/fixtures'), array("--env=test"));

    // seems that no fixtures means table untouched; delete manually
    Doctrine_Core::getTable('DatabaseUsage')->findAll()->delete();
    Doctrine_Core::getTable('UrlUsage')->findAll()->delete();
  }
}

