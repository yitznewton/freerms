<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_LibraryPeerTest extends sfPHPUnitBaseTestCase
{
  protected function _start()
  {
    new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('resolver', 'test', true));
    $loader = new sfPropelData();
    $loader->loadData( sfConfig::get('sf_test_dir').'/data/fixtures/test.yml' );
  }
  
  public function testRetrieveByIp()
  {
    $this->assertInstanceOf( 'Library', LibraryPeer::retrieveByIp('192.168.23.2') );
    $this->assertNull( LibraryPeer::retrieveByIp('8.8.8.8') );
  }
}
