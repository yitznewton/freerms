<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('resolver', 'batch', true);
sfContext::createInstance($configuration);

// Remove the following lines if you don't use the database layer
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();

error_reporting(E_ALL);

$error_state = 0;

$libraries = LibraryPeer::doSelect( new Criteria() );

foreach ( $libraries as $library ) {
  $guard_group = sfGuardGroupPeer::retrieveByPk( $library->getId() );
  
  if ( $guard_group && $guard_group->getName() != $library->getCode() ) {
    $error_state = 1;
    echo 'Name for library ' . $library->getId() . ' does not match:' . "\n"
         . '  library: ' . $library->getCode() . ' / sf_guard_group: '
         . $guard_group->getName() . "\n";
  }
  
  if ( ! $guard_group ) {
    $guard_group = new SfGuardGroup();
    $guard_group->setId( $library->getId() );
    $guard_group->setName( $library->getCode() );
    $guard_group->setDescription( $library->getName() );
    $guard_group->save();
  }
}

exit( $error_state );
