<?php
require_once dirname(__FILE__).'/BackendFunctionalTestCase.php';

class functional_backend_databaseActionsTest extends BackendFunctionalTestCase
{
  public function testHomepageFeatured_WeightSortsCorrectly()
  {
    $this->getTester('192.168.100.100')->
      get('/databases/featured')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'homepageFeatured')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('label', 'Pubmed',
          array('position' => 1))->
      end()
    ;
  }
}

