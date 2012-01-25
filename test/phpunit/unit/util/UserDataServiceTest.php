<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_UserDataServiceTest extends sfPHPUnitBaseTestCase
{
  public function testFactory_freermsSfGuardUser_ReturnsUserDataService()
  {
    $user = $this->getMockBuilder('freermsSfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $this->assertEquals('UserDataService',
      get_class(UserDataService::factory($user)));
  }

  public function testGet_freermsSfGuardUser_ReturnsArray()
  {
    $user = $this->getMockBuilder('freermsSfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $dataService = UserDataService::factory($user);

    $this->assertInternalType('array', $dataService->get());
  }

  public function testGet_freermsSfGuardUserNotAuthenticated_ReturnsEmpty()
  {
    $user = $this->getMockBuilder('freermsSfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $user->expects($this->any())
      ->method('isAuthenticated')
      ->will($this->returnValue(false));

    $dataService = UserDataService::factory($user);

    $this->assertEquals(array(), $dataService->get());
  }

  public function testGet_freermsSfGuardUser_ReturnIncludesExpectedGroups()
  {
    $guardUser = $this->getMockBuilder('sfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $guardUser->expects($this->any())
      ->method('getId')
      ->will($this->returnValue(1));

    $user = $this->getMockBuilder('freermsSfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $user->expects($this->any())
      ->method('isAuthenticated')
      ->will($this->returnValue(true));

    $user->expects($this->any())
      ->method('getGuardUser')
      ->will($this->returnValue($guardUser));

    $query = $this->getMockBuilder('Doctrine_RawSql')
      ->disableOriginalConstructor()
      ->getMock();

    $query->expects($this->any())
      ->method('execute')
      ->will($this->returnValue(array(
        array(1),
        array(2),
      )));

    $data = UserDataService::factory($user)->get($query);

    $this->assertArrayHasKey('groups', $data);
    $this->assertEquals(array(1,2), $data['groups']);
  }
}

