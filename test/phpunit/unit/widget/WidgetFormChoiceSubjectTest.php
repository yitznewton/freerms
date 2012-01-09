<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_WidgetFormChoiceSubjectTest extends sfPHPUnitBaseTestCase
{
  public function testGetChoices_LibraryIdsEmpty_ReturnsEmptyAndAllSubjects()
  {
    $widget = new WidgetFormChoiceSubject();

    $this->assertCount(3, $widget->getChoices());
  }

  public function testGetChoices_LibraryIdsSet_ReturnsEmptyAndSetSubjects()
  {
    $library = Doctrine_Core::getTable('Library')->findOneByCode('TCS');

    $widget = new WidgetFormChoiceSubject(
      array('library_ids' => array($library->getId())));

    $this->assertCount(2, $widget->getChoices());
  }
}

