<?php
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
        checkElement('ul.databases li', true, array('count' => 8))->
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
        checkElement('#subject-select option', true, array('count' => 2))->
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
        checkElement('ul.featured li', true, array('count' => 3))->
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

  public function testAccess_Database_UserDataServiceRecordsGroupsWithoutLibraries()
  {
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

