<?php
require_once dirname(__FILE__).'/../FunctionalTestCase.php';

class FrontendFunctionalTestCase extends FunctionalTestCase
{
  public static function setUpBeforeClass()
  {
    parent::setUpBeforeClass();

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

    // frontend decorator templates for testing
    touch(sfConfig::get('sf_apps_dir').'/frontend/templates/layout_mobile.php');
    touch(sfConfig::get('sf_apps_dir').'/frontend/templates/test1.php');
    touch(sfConfig::get('sf_apps_dir').'/frontend/templates/test1_mobile.php');
    touch(sfConfig::get('sf_apps_dir').'/frontend/templates/test2.php');
  }

  public static function tearDownAfterClass()
  {
    // frontend decorator templates for testing
    unlink(sfConfig::get('sf_apps_dir').'/frontend/templates/layout_mobile.php');
    unlink(sfConfig::get('sf_apps_dir').'/frontend/templates/test1.php');
    unlink(sfConfig::get('sf_apps_dir').'/frontend/templates/test1_mobile.php');
    unlink(sfConfig::get('sf_apps_dir').'/frontend/templates/test2.php');
  }

  protected function getApplication()
  {
    return 'frontend';
  }

  protected function getTester($ip, $headers = array())
  {
    $browser = new sfBrowser(null, $ip);

    foreach ($headers as $key => $value) {
      $browser->setHttpHeader($key, $value);
    }

    return new sfTestFunctional($browser, $this->getTest());
  }

  protected function login(sfTestFunctional $tester, $username, $password)
  {
    $csrf = $tester->getResponseDom()->getElementById('signin__csrf_token')
      ->getAttribute('value');

    $tester->post('/guard/login', array('signin' => array(
      'username' => $username,
      'password' => $password,
      '_csrf_token' => $csrf,
    )));

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);

    $tester->followRedirect();

    return $tester;
  }
}

