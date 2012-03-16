<?php
ini_set('memory_limit', '150M');
require_once dirname(__FILE__).'/FrontendFunctionalTestCase.php';

class functional_frontend_databaseActionsTest extends FrontendFunctionalTestCase
{
  public function testIndex_NoArgsOnsite_GetsIndex()
  {
    $this->getTester('192.168.100.100')->
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

  public function testIndex_DatabaseRoute_GetsIndex()
  {
    $this->getTester('192.168.100.100')->
      get('/database')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()
    ;
  }

  public function testIndex_DatabaseRouteSlash_GetsIndex()
  {
    $this->getTester('192.168.100.100')->
      get('/database/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()
    ;
  }

  public function testIndex_NoArgsOffsite_Gets401()
  {
    $this->getTester('192.168.1.1')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(401)->
      end()
    ;
  }

  public function testIndex_WithSubjectOnsite_GetsRightDatabase()
  {
    $this->getTester('192.168.100.100')->
      get('/?subject=health-sciences')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured', '/ProQuest/')->
      end()
    ;
  }

  public function testIndex_Onsite_GetsCorrectDatabaseCount()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      // includes unavailable, omits hidden

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.databases:nth-child(5) li', 10)->
      end()
    ;
  }

  public function testIndex_Unavailable_DisplaysWithoutLink()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.databases li:contains("Unavailable")', true)->
        checkElement('ul.databases li:contains("Unavailable") a', false)->
      end()
    ;
  }

  public function testIndex_Onsite_SubjectWidgetCorrectCount()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('#subject-select option', 2)->
      end()
    ;
  }

  public function testIndex_Onsite_SubjectWidgetCorrectOrder()
  {
    $tester = $this->getTester('192.1.1.1');

    $tester->get('/');

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->get('/')->
      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('#subject-select option:nth-child(2)', 'Psychology')->
      end()
    ;
  }

  public function testIndex_NoFeaturedSubject_DisplayGeneralFeatured()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured li', 3)->
      end()
    ;
  }

  public function testIndex_WithUnfeaturedSubjectOnsite_NotDisplayFeatured()
  {
    $this->getTester('192.167.100.100')->
      get('/?subject=doesnt-exist')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured', false)->
      end()
    ;
  }

  public function testIndex_LayoutSiteParams_SetsLayoutForLayoutParam()
  {
    sfConfig::set('symfony.view.database_index_layout', null);

    $tester = $this->getTester('192.167.100.100');

    $tester->get('/?layout=test1&site=test2');

    $this->assertEquals('test1',
      sfConfig::get('symfony.view.database_index_layout'));
  }

  public function testIndex_SiteParam_SetsLayoutForSiteParam()
  {
    sfConfig::set('symfony.view.database_index_layout', null);

    $tester = $this->getTester('192.167.100.100');

    $tester->get('/?site=test2');

    $this->assertEquals('test2',
      sfConfig::get('symfony.view.database_index_layout'));
  }

  public function testIndex_TemplateSpecified_SessionMaintainsState()
  {
    sfConfig::set('symfony.view.database_index_layout', null);

    $tester = $this->getTester('192.167.100.100');

    $tester->get('/?site=test2');

    $this->assertEquals('test2',
      sfConfig::get('symfony.view.database_index_layout'));

    sfConfig::set('symfony.view.database_index_layout', null);

    $tester->get('/');

    $this->assertEquals('test2',
      sfConfig::get('symfony.view.database_index_layout'));
  }

  public function testIndex_TemplateChangedSecondRequest_LoadsNewTemplate()
  {
    sfConfig::set('symfony.view.database_index_layout', null);

    $tester = $this->getTester('192.167.100.100');

    $tester->get('/?site=test2');

    $this->assertEquals('test2',
      sfConfig::get('symfony.view.database_index_layout'));

    sfConfig::set('symfony.view.database_index_layout', null);

    $tester->get('/?site=test1');

    $this->assertEquals('test1',
      sfConfig::get('symfony.view.database_index_layout'));
  }

  public function testIndex_HostTemplateExists_SetsLayoutForHost()
  {
    sfConfig::set('symfony.view.database_index_layout', null);

    $tester = $this->getTester('192.167.100.100');

    $browser = new sfBrowser('test1.example.com', '192.167.100.100');
    $browser->restart();

    $tester = new sfTestFunctional($browser, $this->getTest());

    $tester->get('/');

    $this->assertEquals('test1',
      sfConfig::get('symfony.view.database_index_layout'));
  }

  public function testIndex_HostTemplateNotExists_SetsGenericLayout()
  {
    sfConfig::set('symfony.view.database_index_layout', null);

    $tester = $this->getTester('192.167.100.100');

    $browser = new sfBrowser('foo.example.com', '192.167.100.100');
    $browser->restart();

    $tester = new sfTestFunctional($browser, $this->getTest());

    $tester->get('/');

    $this->assertNull(sfConfig::get('symfony.view.database_index_layout'));
  }

  public function testIndex_ExpectedNumberOfDescriptions()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.databases:nth-child(5) .description', 2)->
      end()
    ;
  }

  public function testIndex_ExpectedNumberOfFeaturedDescriptions()
  {
    $this->getTester('192.168.100.100')->
      get('/')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'index')->
      end()->

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.featured .description', 1)->
      end()
    ;
  }

  public function testLogout_LoggedIn_ClearsAttributes()
  {
    $tester = $this->getTester('192.1.1.1');

    $tester->get('/');

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');
    
    $tester->get('/');

    $this->assertFalse($tester->getUser()->getAttribute('onsiteLibraryId'));

    $tester->get('/logout');

    $this->assertNull($tester->getUser()->getAttribute('onsiteLibraryId'));
  }

  public function testAccess_AltIdCaseChanged_RedirectsToExpected()
  {
    $this->getTester('192.167.100.100')->
      get('/database/alt/EBS')->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'access')->
      end()->

      with('response')->begin()->
        isStatusCode(302)->
        isHeader('Location', 'http://ebsco.example.org/')->
      end()
    ;
  }
  
  public function testAccess_Subscribed_RedirectsToExpected()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EBSCO');

    $this->getTester('192.167.100.100')->
      get('/database/' . $database->getId())->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'access')->
      end()->

      with('response')->begin()->
        isStatusCode(302)->
        isHeader('Location', 'http://ebsco.example.org/')->
      end()
    ;
  }

  public function testAccess_NotSubscribed_403()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('ebrary');

    $this->getTester('192.167.100.100')->
      get('/database/' . $database->getId())->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'access')->
      end()->

      with('response')->begin()->
        isStatusCode(403)->
      end()
    ;
  }

  public function testAccess_Unavailable_Throws404()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Unavailable');

    $this->getTester('192.168.100.100')->
      get('/database/' . $database->getId())->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'access')->
      end()->

      with('response')->begin()->
        isStatusCode(404)->
      end()
    ;
  }

  public function testAccess_Database_RecordsSingleUsage()
  {
    $this->assertEquals(0, Doctrine_Core::getTable('DatabaseUsage')
      ->findAll()->count());

    // unrestricted
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Pubmed');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrariestcstcny');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $this->assertEquals(1, Doctrine_Core::getTable('DatabaseUsage')
      ->findAll()->count());
  }

  public function testAccess_AccessControlNotValidYaml_Redirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Invalid Access');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $this->assertEquals(302, $tester->getResponse()->getStatusCode());
  }
  
  public function testAccess_AccessControlHasOneOfTwoOrred_Redirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Orred');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $this->assertEquals(302, $tester->getResponse()->getStatusCode());
  }

  public function testAccess_AccessControlHasOneOfTwoAnded_Unauthorized()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Anded');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrarytcs', 'jimbobjoe');

    $this->assertEquals(403, $tester->getResponse()->getStatusCode());
  }

  public function testAccess_AccessControlHasTwoOfTwoAnded_Redirects()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Anded');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $this->assertEquals(302, $tester->getResponse()->getStatusCode());
  }

  public function testAccess_Database_UserDataServiceRecordsGroupsWithoutLibraries()
  {
    // unrestricted
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Pubmed');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $databaseUsage = Doctrine_Core::getTable('DatabaseUsage')
      ->findAll()->getFirst();

    $additionalData = $databaseUsage->getAdditionalData();

    $this->assertCount(2, $additionalData['groups']);
  }

  public function testAccess_Database_SecondAccessInSession_NotRecordsUsage()
  {
    $this->assertEquals(0, Doctrine_Core::getTable('DatabaseUsage')
      ->findAll()->count());

    // unrestricted
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('Pubmed');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCNY');

    $user = Doctrine_Core::getTable('sfGuardUser')
      ->findOneByUsername('haslibrariestcstcny');

    $tester = $this->getTester('192.1.1.1');

    $tester->get('/database/' . $database->getId());

    $tester = $this->login($tester, 'haslibrariestcstcny', 'somesecret');

    $tester->get('/database/' . $database->getId());

    $this->assertEquals(1, Doctrine_Core::getTable('DatabaseUsage')
      ->findAll()->count());
  }

  public function testLogout_RedirectsToHome()
  {
    $tester = $this->getTester('192.167.100.100');

    $tester->get('/logout');

    $tester->test()->is($tester->getResponse()
      ->getHttpHeader('Location'), 'http://localhost/index.php/');
  }
}

