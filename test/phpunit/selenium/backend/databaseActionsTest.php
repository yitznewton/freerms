<?php
require_once dirname(__FILE__).'/../FreermsSeleniumTestCase.php';

class selenium_backend_databaseActionsTest extends FreermsSeleniumTestCase
{
  public function testEdit_CloneWithChanges_RaisesConfirmation()
  {
    $this->open('backend.php/databases');
    $this->clickAndWait('link=A Sorter');
    $this->type('id=database_description', 'foo');
    $this->clickAndWait('link=Clone');
    
    //$this->assertConfirmationPresent();
    $this->assertConfirmation('You have unsaved changes; press OK to continue '
      . 'or Cancel to return to editing.');
  }

  public function testEdit_CloneWithoutChanges_NoConfirmation()
  {
    $this->open('backend.php/databases');
    $this->clickAndWait('link=A Sorter');
    $this->clickAndWait('link=Clone');
    
    $this->assertFalse($this->isConfirmationPresent());
  }
}
