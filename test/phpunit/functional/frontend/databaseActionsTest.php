<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class functional_frontend_databaseActionsTest extends sfPHPUnitBaseFunctionalTestCase
{
  protected function getApplication()
  {
    return 'frontend';
  }

  public function testDefault()
  {
    $browser = $this->getBrowser();

    $browser->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('h2', '/Databases/')->
      end()
    ;
  }
}
