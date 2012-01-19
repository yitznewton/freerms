<?php

require_once dirname(__FILE__).'/FrontendFunctionalTestCase.php';

class functional_frontend_refererAccessActionTest extends FrontendFunctionalTestCase
{
  public function testAccess_Offsite_RequiresLogin()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester->test()->is($tester->getResponse()->getStatusCode(), 401);
  }

  public function testAccess_OffsiteNoReferralNote_InternalRedirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);
    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), '_/refer$_');
  }

  public function testAccess_OffsiteNoReferralNote_ExternalRedirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ProQuest');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->followRedirect();

    $css = new sfDomCssSelector($tester->getResponseDom());

    $tester->test()->is(count($css->matchAll('#database-link-automatic')), 1);
  }

  public function testAccess_OffsiteReferralNote_InternalRedirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Referral Note Database');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->test()->is($tester->getResponse()->getStatusCode(), 302);
    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), '_/refer$_');
  }

  public function testAccess_OffsiteReferralNote_NotExternalRedirect()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Referral Note Database');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->followRedirect();

    $css = new sfDomCssSelector($tester->getResponseDom());

    $tester->test()->is(count($css->matchAll('#database-link-automatic')), 0);
  }

  public function testAccess_OffsiteReferralNote_DisplaysNoteAndLink()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Referral Note Database');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->followRedirect();

    $css = new sfDomCssSelector($tester->getResponseDom());
    
    $tester->with('response')->begin()->
      checkElement('.referral-note', $database->getReferralNote())->
      checkElement('.database-link', true)->
    end();
  }
}

