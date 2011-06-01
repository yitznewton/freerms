<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_freermsUserAffiliationTest extends sfPHPUnitBaseTestCase
{
  protected function _start()
  {
    new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('resolver', 'test', true));
  }
  
  public function testGet()
  {
    $affiliated_user   = new freermsUserAffiliated_AffiliationTest();
    $unaffiliated_user = new freermsUserUnaffiliated_AffiliationTest();
    
    // offsite
    
    $_SERVER['REMOTE_ADDR']      = '8.8.8.8';
    
    $affiliated_affilation_obj
      = new freermsUserAffiliation( $affiliated_user );
    
    $unaffiliated_affilation_obj
      = new freermsUserAffiliation( $unaffiliated_user );
    
    $this->assertContains( 456, $affiliated_affilation_obj->get() );
    $this->assertEmpty( $unaffiliated_affilation_obj->get() );
    
    // onsite
    
    $random_library_ip_range = IpRangePeer::doSelectOne( new Criteria() );
    
    $_SERVER['REMOTE_ADDR'] = $random_library_ip_range->getStartIp();
    
    $affiliated_affilation_obj
      = new freermsUserAffiliation($affiliated_user );
    
    $unaffiliated_affilation_obj
      = new freermsUserAffiliation( $unaffiliated_user );
    
    $this->assertContains( $random_library_ip_range->getLibrary()->getId(),
      $affiliated_affilation_obj->get() );
    
    $this->assertContains( $random_library_ip_range->getLibrary()->getId(),
      $unaffiliated_affilation_obj->get() );
  }
  
  public function testGetOne()
  {
    $affiliated_user   = new freermsUserAffiliated_AffiliationTest();
    $unaffiliated_user = new freermsUserUnaffiliated_AffiliationTest();
    
    $_SERVER['REMOTE_ADDR'] = '8.8.8.8';
    
    $affiliated_affilation_obj
      = new freermsUserAffiliation( $affiliated_user );
    
    $unaffiliated_affilation_obj
      = new freermsUserAffiliation( $unaffiliated_user );
    
    $this->assertEquals( 456, $affiliated_affilation_obj->getOne() );
    $this->assertNull( $unaffiliated_affilation_obj->getOne() );
  }
}

class freermsUserAffiliated_AffiliationTest implements freermsUserInterface
{
  public function getUsername() {}
  
  public function getLibraryIds()
  {
    return array( 456 ); 
  }
}

class freermsUserUnaffiliated_AffiliationTest implements freermsUserInterface
{
  public function getUsername() {}
  
  public function getLibraryIds()
  {
    return array(); 
  }
}
