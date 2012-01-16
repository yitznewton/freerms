<?php
require_once dirname(__FILE__).'/FrontendFunctionalTestCase.php';

class functional_frontend_accessActionsTest extends FrontendFunctionalTestCase
{
  public function testAccess_EzproxyUrl_InvalidUrlThrows404()
  {
    $url = 'somemessedupurl';

    $tester = $this->getTester('192.167.100.100');

    $tester->get("/url/$url");

    $tester->test()->is($tester->getResponse()->getStatusCode(), 404);
  }

  public function testAccess_EzproxyUrlOnsite_RedirectsStraight()
  {
    $url = 'http://www.example.org';

    $tester = $this->getTester('192.167.100.100');

    $tester->get("/url/$url");

    $tester->test()->is($tester->getResponse()->getStatusCode(),
      302);

    $tester->test()->is($tester->getResponse()->getHttpHeader('Location'),
      $url);
  }

  public function testAccess_EzproxyUrl_RedirectHasProxyHost()
  {
    $url = 'http://www.example.org';

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $tester = $this->getTester('192.1.1.1');

    $tester->get("/url/$url");

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $library_ids = $tester->getContext()->getAffiliation()->getLibraryIds();

    $library = Doctrine_Core::getTable('Library')
      ->find($library_ids[0]);

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), "`^http://{$library->getEzproxyHost()}`");
  }

  public function testAccess_EzproxyUrl_RedirectHasUsername()
  {
    $url = 'http://www.example.org';

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $tester = $this->getTester('192.1.1.1');

    $tester->get("/url/$url");

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), '/user=haslibrarytcs/');
  }

  public function testAccess_EzproxyUrl_RedirectHasUrl()
  {
    $url = 'http://www.example.org';

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrarytcs');

    $tester = $this->getTester('192.1.1.1');

    $tester->get("/url/$url");

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), "`$url`");
  }
}

