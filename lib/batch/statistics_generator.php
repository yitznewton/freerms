<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('reports', 'batch', true);
sfContext::createInstance($configuration);

// Remove the following lines if you don't use the database layer
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();

error_reporting(E_ALL);

$startDate = '2011-01-01';
$endDate   = '2012-12-31';

$startDateUnix = strtotime($startDate);
$endDateUnix   = strtotime($endDate);

$timeDifference = $endDateUnix - $startDateUnix;

$databaseIds = array_map(function($database) {
  return $database['id']; 
}, Doctrine_Core::getTable('Database')->findAll()->toArray());

$libraryIds = array_map(function($library) {
  return $library['id']; 
}, Doctrine_Core::getTable('Library')->findAll()->toArray());

$databaseIds = array_flip($databaseIds);
$libraryIds = array_flip($libraryIds);

for ($i = 0; $i < 20000; $i++) {
  $du = new DatabaseUsage();
  $du->setDatabaseId(array_rand($databaseIds));
  $du->setLibraryId(array_rand($libraryIds));
  $du->setIsOnsite(rand(0,100) % 4 !== 0);  // weighted
  $du->setIsMobile(rand(0,100) % 5 === 0);  // weighted
  $du->setTimestamp(date('Y-m-d', $startDateUnix + rand(0, $timeDifference)));
  $du->setSessionid(md5($i));

  $du->save();
  $du->free(true);

  if ($i % 50 === 0) {
    echo '.';
  }
}

