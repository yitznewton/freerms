<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_freermsValidatorDatabaseSortTitleTest extends sfPHPUnitBaseTestCase
{
  public function testClean_BlankSortTitle_FillsIn()
  {
    $validator = new freermsValidatorDatabaseSortTitle();

    $values = array('title' => 'Jim Bob', 'sort_title' => '');
    $cleanValues = $validator->clean($values);

    $this->assertEquals('Jim Bob', $cleanValues['sort_title']);
  }

  public function testClean_HasSortTitle_NotFillsIn()
  {
    $validator = new freermsValidatorDatabaseSortTitle();

    $values = array('title' => 'Jim Bob', 'sort_title' => 'Pete');
    $cleanValues = $validator->clean($values);

    $this->assertEquals('Pete', $cleanValues['sort_title']);
  }
}

