<?php

require_once dirname(__FILE__).'/FrontendFunctionalTestCase.php';

class functional_frontend_ezproxyAccessActionTest extends FrontendFunctionalTestCase
{
  public function testAccess_EzproxyOnsite_RedirectsStraight()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EZproxy database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $tester = $this->getTester('192.167.100.100');

    $tester->get('/database/' . $database->getId());

    $tester->test()->is($tester->getResponse()->getHttpHeader('Location'),
      $database->getAccessUrl());
  }

  public function testAccess_Ezproxy_RedirectHasProxyHost()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EZproxy database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), "`^http://{$library->getEzproxyHost()}`");
  }

  public function testAccess_Ezproxy_RedirectHasUsername()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EZproxy database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), '/user=haslibrarytcs/');
  }

  public function testAccess_Ezproxy_RedirectHasUrl()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EZproxy database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), "`url={$database->getAccessUrl()}`");
  }
}

