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
}
