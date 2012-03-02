<?php
require_once dirname(__FILE__).'/../DoctrineTestCase.php';
require_once dirname(__FILE__).'/../../../../apps/frontend/lib/user/freermsUserAffiliation.class.php';

class unit_freermsUserAffiliationTest extends DoctrineTestCase
{
  public function setUp()
  {
    $this->user = $this->getMockBuilder('freermsSfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $this->request = $this->getMockBuilder('sfWebRequest')
      ->disableOriginalConstructor()
      ->getMock();
  }

  public function testGetLibraryIds_Onsite_IncludesOnsiteLibraryId()
  {
    $this->user
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array()));

    $this->request
      ->expects($this->any())
      ->method('getRemoteAddress')
      ->will($this->returnValue('192.168.100.100'));

    $library = Doctrine_Core::getTable('Library')
      ->findOneByIpAddress('192.168.100.100');

    $affiliation = new freermsUserAffiliation($this->user, $this->request,
      new sfNamespacedParameterHolder());

    $this->assertContains($library->getId(), $affiliation->getLibraryIds());
  }

  public function testGetLibraryIds_Onsite_IncludesUserLibraryId()
  {
    $this->user
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array('1')));

    $this->request
      ->expects($this->any())
      ->method('getRemoteAddress')
      ->will($this->returnValue('192.168.100.100'));

    $affiliation = new freermsUserAffiliation($this->user, $this->request,
      new sfNamespacedParameterHolder());

    $this->assertContains('1', $affiliation->getLibraryIds());
  }

  public function testGetLibraryIds_Offsite_IncludesUserLibraryId()
  {
    $this->user
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array('1')));

    $this->request
      ->expects($this->any())
      ->method('getRemoteAddress')
      ->will($this->returnValue('192.1.1.1'));

    $affiliation = new freermsUserAffiliation($this->user, $this->request,
      new sfNamespacedParameterHolder());

    $this->assertContains('1', $affiliation->getLibraryIds());
  }

  public function testIsOnsite_Onsite_ReturnsTrue()
  {
    $this->user
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array()));

    $this->request
      ->expects($this->any())
      ->method('getRemoteAddress')
      ->will($this->returnValue('192.168.100.100'));

    $affiliation = new freermsUserAffiliation($this->user, $this->request,
      new sfNamespacedParameterHolder());

    $this->assertTrue($affiliation->isOnsite());
  }

  public function testIsOnsite_Offsite_ReturnsFalse()
  {
    $this->user
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array()));

    $this->request
      ->expects($this->any())
      ->method('getRemoteAddress')
      ->will($this->returnValue('192.1.1.1'));

    $affiliation = new freermsUserAffiliation($this->user, $this->request,
      new sfNamespacedParameterHolder());

    $this->assertFalse($affiliation->isOnsite());
  }
}

