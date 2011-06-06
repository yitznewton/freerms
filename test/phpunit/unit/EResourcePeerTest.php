<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_EResourcePeerTest extends sfPHPUnitBaseTestCase
{
  protected function _start()
  {
    new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('resolver', 'test', true));
  }
  
  public function testRetrieveByAffiliationAndSubject()
  {
    $real_subject  = DbSubjectPeer::retrieveBySlug( 'health-sciences' );
    $dummy_subject = new DbSubject();
    
    $er = EResourcePeer::retrieveByPK( 390 );
    
    $this->assertEmpty( EResourcePeer::retrieveByAffiliationAndSubject(
      array(), $dummy_subject ));
    
    $this->assertEmpty( EResourcePeer::retrieveByAffiliationAndSubject(
      array(15), $dummy_subject ));
    
    $this->assertEmpty( EResourcePeer::retrieveByAffiliationAndSubject(
      array(), $real_subject ));
    
    $this->assertContains( $er,
      EResourcePeer::retrieveByAffiliationAndSubject(
        array(15), $real_subject ));
  }
  
  public function testRetrieveByAffiliationAndSubjectFeatured()
  {
    $real_subject  = DbSubjectPeer::retrieveBySlug( 'health-sciences' );
    $dummy_subject = new DbSubject();
    
    // FIXME: this assumes that 226 and only 226 is set as featured
    $featured_er   = EResourcePeer::retrieveByPK( 226 );
    
    $this->assertEmpty( EResourcePeer::retrieveByAffiliationAndSubject(
      array(), $dummy_subject, true ));
    
    $this->assertEmpty( EResourcePeer::retrieveByAffiliationAndSubject(
      array(15), $dummy_subject, true ));
    
    $this->assertEmpty( EResourcePeer::retrieveByAffiliationAndSubject(
      array(), $real_subject, true ));
    
    $this->assertContainsOnly( $featured_er,
      EResourcePeer::retrieveByAffiliationAndSubject(
        array(15), $real_subject, true ));
  }
}
