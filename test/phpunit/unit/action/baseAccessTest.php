<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';
require_once __DIR__.'/AccessTestCase.php';
require_once __DIR__.'/../../../../apps/frontend/modules/access/actions/baseAction.class.php';

class unit_baseAccessTest extends AccessTestCase
{
  /**
   * @expectedException accessUnauthorizedException
   */
  public function testExecute_NotSubscribed_ThrowsException()
  {
    $this->affiliation
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array()));

    $request = new sfWebRequest(new sfEventDispatcher());

    $context = sfContext::createInstance($this->configuration);
    $context->setAffiliation($this->affiliation);
    $context->setRequest($request);
    $context->getUser()->setFlash('database_library_ids', array(1));

    $action = new baseAction($context, 'access', 'base');
    $action->execute($request);
  }

  /**
   * @expectedException sfStopException
   */
  public function testExecute_DatabaseOneUserOneAffiliation_Redirects()
  {
    $this->affiliation
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array(1)));

    $request = new sfWebRequest(new sfEventDispatcher());

    $context = sfContext::createInstance($this->configuration);
    $context->setAffiliation($this->affiliation);
    $context->setRequest($request);
    $context->getUser()->setFlash('database_library_ids', array(1));
    $context->getUser()->setFlash('database_url', 'http://www.example.org');

    $action = $this->getMock('baseAction', null,
      array($context, 'access', 'base'));

    // why doesn't this work?
    // $action
    //   ->expects($this->once())
    //   ->method('redirect');

    $action->execute($request);
  }

  /**
   * @expectedException sfStopException
   */
  public function testExecute_DatabaseOneUserManyAffiliations_Redirects()
  {
    $this->affiliation
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array(1,2)));

    $request = new sfWebRequest(new sfEventDispatcher());

    $context = sfContext::createInstance($this->configuration);
    $context->setAffiliation($this->affiliation);
    $context->setRequest($request);
    $context->getUser()->setFlash('database_library_ids', array(1));
    $context->getUser()->setFlash('database_url', 'http://www.example.org');

    $action = $this->getMock('baseAction', null,
      array($context, 'access', 'base'));

    $action->execute($request);
  }

  /**
   * @expectedException sfStopException
   */
  public function testExecute_DatabaseManyUserOneAffiliations_Redirects()
  {
    $this->affiliation
      ->expects($this->any())
      ->method('getLibraryIds')
      ->will($this->returnValue(array(1)));

    $request = new sfWebRequest(new sfEventDispatcher());

    $context = sfContext::createInstance($this->configuration);
    $context->setAffiliation($this->affiliation);
    $context->setRequest($request);
    $context->getUser()->setFlash('database_library_ids', array(1,2));
    $context->getUser()->setFlash('database_url', 'http://www.example.org');

    $action = $this->getMock('baseAction', null,
      array($context, 'access', 'base'));

    $action->execute($request);
  }
}

