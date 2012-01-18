<?php

require_once dirname(__FILE__).'/FrontendFunctionalTestCase.php';

class functional_frontend_ebrarySSOAccessActionTest extends FrontendFunctionalTestCase
{
  public function testExecute_OnsiteNoSigninPassed_RedirectsPlainUrl()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ebrary');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $tester = $this->getTester('192.168.100.100');

    $tester->get('/database/' . $database->getId());

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->is($tester->getResponse()->getHttpHeader('Location'),
      $database->getAccessUrl());
  }

  public function testExecute_OnsiteSigninPassed_RedirectsEzproxyUnauthUrl()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ebrary');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $tester = $this->getTester('192.168.100.100');

    $tester->get('/database/' . $database->getId() . '?signin');

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()->getHttpHeader('Location'),
      '`url=' . $this->getUrl($database, $library) . '`');
  }

  public function testExecute_Offsite_RedirectsEzproxyUnauthUrl()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ebrary');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()->getHttpHeader('Location'),
      '`url=' . $this->getUrl($database, $library) . '`');
  }
  
  protected function getUrl(Database $database, Library $library)
  {
    preg_match('`[^/]+$`', $database->getAccessUrl(), $site_matches);

    return 'http://' . $library->getEzproxyHost() . '/ebrary/'
           . $site_matches[0] . '/unauthorized';
  }
}

