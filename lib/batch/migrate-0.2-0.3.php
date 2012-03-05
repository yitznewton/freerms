<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'batch', true);
sfContext::createInstance($configuration);

// Remove the following lines if you don't use the database layer
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();

error_reporting(E_ALL);

foreach (Doctrine_Core::getTable('IpRange')->findAll() as $ipRange) {
  // invoke setter to cover start_ip_sort and end_ip_sort
  $ipRange->setStartIp($ipRange->getStartIp());
  $ipRange->setEndIp($ipRange->getEndIp());
  $ipRange->save();
}

