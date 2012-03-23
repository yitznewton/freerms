<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('reports', 'batch', true);
sfContext::createInstance($configuration);

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

$pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
$st = $pdo->prepare('INSERT INTO database_usage (database_id, library_id, '
  . 'is_onsite, is_mobile, timestamp, sessionid) VALUES '
  . '(:database_id, :library_id, :is_onsite, :is_mobile, :timestamp, '
  . ':sessionid)');

for ($i = 0; $i < 20000; $i++) {
  $st->execute(array(
    ':database_id' => array_rand($databaseIds),
    ':library_id' => array_rand($libraryIds),
    ':is_onsite' => rand(0,100) % 4 === 0 ? 0 : 1,
    ':is_mobile' => rand(0,100) % 5 === 0 ? 1 : 0,
    ':timestamp' => date('Y-m-d', $startDateUnix + rand(0, $timeDifference)),
    ':sessionid' => md5($i),
  ));

  if ($i % 50 === 0) {
    echo '.';
  }
}

echo "\n";

