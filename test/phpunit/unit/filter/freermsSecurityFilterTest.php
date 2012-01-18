<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../../../apps/frontend/lib/filter/freermsSecurityFilter.class.php';

class unit_freermsSecurityFilterTest extends sfPHPUnitBaseTestCase
{
  protected function getUser($isAuthenticated)
  {
    $user = $this->getMockBuilder('freermsSfGuardUser')
      ->disableOriginalConstructor()
      ->getMock();

    $user->expects($this->any())
      ->method('isAuthenticated')
      ->will($this->returnValue($isAuthenticated));

    return $user;
  }

  public function testExecute_LoggedIn_DoesNotForward()
  {
    $controller = $this->getMockBuilder('sfController')
      ->disableOriginalConstructor()
      ->getMock();

    // here is the mock assertion
    $controller->expects($this->never())
      ->method('forward');

    $affiliation = $this->getMockBuilder('freermsUserAffiliation')
      ->disableOriginalConstructor()
      ->getMock();

    $affiliation->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array(1)));

    $context = $this->getMock('sfContext');

    $context->expects($this->any())
      ->method('getUser')
      ->will($this->returnValue($this->getUser(true)));

    $context->expects($this->any())
      ->method('getRequest')
      ->will($this->returnValue(new sfWebRequest(new sfEventDispatcher)));

    $context->expects($this->any())
      ->method('getController')
      ->will($this->returnValue($controller));

    $context->expects($this->any())
      ->method('getAffiliation')
      ->will($this->returnValue($affiliation));

    $filter = new freermsSecurityFilter($context);

    try {
      $filter->execute(new sfFilterChain());
    }
    catch (sfStopException $e) {
      $this->fail();
    }
  }

  public function testExecute_NotLoggedInForceLoginRequested_Forwards()
  {
    $request = new sfWebRequest(new sfEventDispatcher());
    $request->getParameterHolder()->add(array('force-login' => ''));

    $controller = $this->getMockBuilder('sfController')
      ->disableOriginalConstructor()
      ->getMock();

    // here is the mock assertion
    $controller->expects($this->once())
      ->method('forward');

    $affiliation = $this->getMockBuilder('freermsUserAffiliation')
      ->disableOriginalConstructor()
      ->getMock();

    $affiliation->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array()));

    $context = $this->getMock('sfContext');

    $context->expects($this->any())
      ->method('getUser')
      ->will($this->returnValue($this->getUser(false)));

    $context->expects($this->any())
      ->method('getRequest')
      ->will($this->returnValue($request));

    $context->expects($this->any())
      ->method('getController')
      ->will($this->returnValue($controller));

    $context->expects($this->any())
      ->method('getAffiliation')
      ->will($this->returnValue($affiliation));

    $filter = new freermsSecurityFilter($context);

    try {
      $filter->execute(new sfFilterChain());
    }
    catch (sfStopException $e) {
      return;
    }

    $this->fail();
  }

  public function testExecute_LoggedInForceLoginRequested_DoesNotForward()
  {
    $request = new sfWebRequest(new sfEventDispatcher());
    $request->getParameterHolder()->add(array('force-login' => ''));

    $controller = $this->getMockBuilder('sfController')
      ->disableOriginalConstructor()
      ->getMock();

    // here is the mock assertion
    $controller->expects($this->never())
      ->method('forward');

    $affiliation = $this->getMockBuilder('freermsUserAffiliation')
      ->disableOriginalConstructor()
      ->getMock();

    $affiliation->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array(1)));

    $context = $this->getMock('sfContext');

    $context->expects($this->any())
      ->method('getUser')
      ->will($this->returnValue($this->getUser(true)));

    $context->expects($this->any())
      ->method('getRequest')
      ->will($this->returnValue($request));

    $context->expects($this->any())
      ->method('getController')
      ->will($this->returnValue($controller));

    $context->expects($this->any())
      ->method('getAffiliation')
      ->will($this->returnValue($affiliation));

    $filter = new freermsSecurityFilter($context);

    try {
      $filter->execute(new sfFilterChain());
    }
    catch (sfStopException $e) {
      $this->fail();
    }

  }

  public function testExecute_NotLoggedInNoAffiliatedLibraries_Forwards()
  {
    $this->markTestIncomplete();

    $request = new sfWebRequest(new sfEventDispatcher());

    $controller = $this->getMockBuilder('sfController')
      ->disableOriginalConstructor()
      ->getMock();

    // here is the mock assertion
    $controller->expects($this->once())
      ->method('forward');

    $affiliation = $this->getMockBuilder('freermsUserAffiliation')
      ->disableOriginalConstructor()
      ->getMock();

    $affiliation->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array()));

    $context = $this->getMock('sfContext');

    $context->expects($this->any())
      ->method('getUser')
      ->will($this->returnValue($this->getUser(false)));

    $context->expects($this->any())
      ->method('getRequest')
      ->will($this->returnValue($request));

    $context->expects($this->any())
      ->method('getController')
      ->will($this->returnValue($controller));

    // FIXME: after this, $context->getAffiliation() is returning
    // the test object, not $affiliation
    $context->expects($this->any())
      ->method('getAffiliation')
      ->will($this->returnValue($affiliation));

    $filter = new freermsSecurityFilter($context);

    try {
      $filter->execute(new sfFilterChain());
    }
    catch (sfStopException $e) {
      return;
    }

    $this->fail();
  }
}

