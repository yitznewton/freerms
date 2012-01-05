<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_FrontendHelperTest extends sfPHPUnitBaseTestCase
{
  public function setUp()
  {
    $this->getContext()->getConfiguration()->loadHelpers(
      array('Tag', 'Url', 'Frontend'));
  }

  protected function getApplication()
  {
    return 'frontend';
  }

  public function testLinkToDatabase_ReturnsLink()
  {
    $database = new Database();
    $database->setId(1);
    $database->setTitle('foo');
    $database->setSortTitle('foo');

    $this->assertRegExp('/^<a href=".*\/database\/1">foo<\/a>$/',
      link_to_database($database));
  }
}

