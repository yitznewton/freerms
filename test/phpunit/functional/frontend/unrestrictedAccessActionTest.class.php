<?php

require_once dirname(__FILE__).'/FrontendFunctionalTestCase.php';

class functional_frontend_unrestrictedAccessActionTest extends FrontendFunctionalTestCase
{
  public function testAccess_OffsiteNotLoggedIn_Redirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Pubmed');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester->test()->is($tester->getResponse()->getHttpHeader('Location'),
      $database->getAccessUrl());
  }
}

