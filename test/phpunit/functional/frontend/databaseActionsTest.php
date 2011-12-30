<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class functional_frontend_databaseActionsTest extends sfPHPUnitBaseFunctionalTestCase
{
  protected function getApplication()
  {
    return 'frontend';
  }

  public function testDefault_NoArgs_GetsIndex()
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

  public function testDefault_WithSubject_GetsRightDatabase()
  {
    $browser = $this->getBrowser();

    $browser->
      get('/?subject=health-sciences')->

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
