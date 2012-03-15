<?php
require_once dirname(__FILE__).'/BackendFunctionalTestCase.php';

class functional_backend_databaseActionsTest extends BackendFunctionalTestCase
{
  public function testHomepageFeatured_WeightSortsCorrectly()
  {
    $this->getBrowser()->
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

  public function testDatabaseEdit_AccessActionSelectGroups_Exist()
  {
    // this assumes that there are both standard and custom actions
    // in the frontend app

    $database = Doctrine_Core::getTable('Database')->createQuery('d')
      ->fetchOne();

    $this->getBrowser()->
      get('/databases/'.$database->getId().'/edit')->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('#database_access_action_onsite optgroup', 2)->
      end()
    ;
  }
}

