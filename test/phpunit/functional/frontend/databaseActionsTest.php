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

      with('response')->begin()->
        isStatusCode(200)->
        checkElement('ul.databases li', true, array('count' => 5))->
      end()
    ;
  }

  public function testIndex_Onsite_SubjectWidgetCorrectCount()
  {
    $this->getTester('192.167.100.100')->
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
        checkElement('ul.featured li', true, array('count' => 2))->
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

  public function testAccess_Ezproxy_RedirectHasProxyHost()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EZproxy database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $tester = $this->getTester('192.167.100.100');

    $tester->
      get('/database/' . $database->getId())->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'access')->
      end()->

      with('response')->begin()->
        isStatusCode(302)->
      end()
    ;

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), "/{$library->getEzproxyHost()}/");
  }

  public function testAccess_Ezproxy_RedirectHasUsername()
  {
    $this->markTestSkipped();
  }

  public function testAccess_Ezproxy_RedirectHasUrl()
  {
    $database = Doctrine_Core::getTable('Database')
      ->findOneByTitle('EZproxy database');

    $library = Doctrine_Core::getTable('Library')
      ->findOneByCode('TCS');

    $tester = $this->getTester('192.167.100.100');

    $tester->
      get('/database/' . $database->getId())->

      with('request')->begin()->
        isParameter('module', 'database')->
        isParameter('action', 'access')->
      end()->

      with('response')->begin()->
        isStatusCode(302)->
      end()
    ;

    $tester->test()->like($tester->getResponse()
      ->getHttpHeader('Location'), "_{$database->getAccessUrl()}_");
  }
}

