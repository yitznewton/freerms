<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_LibraryPeerTest extends sfPHPUnitBaseTestCase
{
  protected function _start()
  {
    new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('resolver', 'test', true));
  }
  
  public function testRetrieveByIp()
  {
    $this->assertInstanceOf( 'Library', LibraryPeer::retrieveByIp('192.168.23.2') );
    $this->assertNull( LibraryPeer::retrieveByIp('8.8.8.8') );
  }
  
  public function testGetFirstForUser()
  {
    $user = new freermsTestUserNotNull();
    
    $this->assertInstanceOf( 'Library',
      LibraryPeer::getFirstForUser($user) );
    
    $user = new freermsTestUserNull();
    
    $this->assertNull( LibraryPeer::getFirstForUser($user) );
  }
}

/**
 * Included this class, because PHPUnit mocks do not support interface
 * type hinting
 */
class freermsTestUserNotNull implements freermsUserInterface
{
  public function getLibraryIds()
  {
    return array( LibraryPeer::doSelectOne( new Criteria() )->getId() );
  }
}

/**
 * Included this class, because PHPUnit mocks do not support interface
 * type hinting
 */
class freermsTestUserNull implements freermsUserInterface
{
  public function getLibraryIds()
  {
    return array();
  }
}
