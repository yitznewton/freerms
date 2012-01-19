<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_freermsValidatorTest extends sfPHPUnitBaseTestCase
{
  /**
   * @expectedException sfValidatorError
   */
  public function testClean_InvalidYaml_ThrowsException()
  {
    $validator = new freermsValidatorYaml();
    $validator->clean(array('not valid yaml'));
  }

  public function testClean_ValidYaml_ReturnsExpectedArray()
  {
    $validator = new freermsValidatorYaml();

    $yaml = '
      this:
        is: { some: valid }
        yaml: too right
    ';

    $this->assertEquals(sfYaml::load(trim($yaml)),
      sfYaml::load($validator->clean($yaml)));
  }
}

