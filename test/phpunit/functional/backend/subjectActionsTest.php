<?php
require_once dirname(__FILE__).'/BackendFunctionalTestCase.php';

class functional_backend_subjectActionsTest extends BackendFunctionalTestCase
{
  public function testEdit_WeightSortsCorrectly()
  {
    $this->getTester('192.168.100.100')->
      get('/subjects')->
      click('Health Sciences')->

      with('request')->begin()->
        isParameter('module', 'subject')->
        isParameter('action', 'edit')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('label.DatabaseSubjectForm', 'ProQuest',
          array('position' => 1))->
      end()
    ;
  }
}

