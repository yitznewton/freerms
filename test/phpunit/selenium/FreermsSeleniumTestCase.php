<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class FreermsSeleniumTestCase extends PHPUnit_Extensions_SeleniumTestCase
{
  public static $browsers = array(
    array(
      'name' => 'Firefox on Win7',
      'browser' => '*firefox',
      'host' => '192.168.65.53',
      'port' => 4444,
      'timeout' => 30000,
    ),
  );

  protected function setUp()
  {
    $this->setBrowserUrl('http://dev-2/symfony1_0/web/');
  }
}

