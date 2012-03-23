<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

class unit_freermsValidatorMonthTest extends sfPHPUnitBaseTestCase
{
  public function setUp()
  {
    $this->validator = new freermsValidatorMonth();
  }

  public function testClean_GoodDate_Returns()
  {
    $date = array(
      'year' => '2010',
      'month' => '01',
    );

    $this->assertEquals('2010-01', $this->validator->clean($date));
  }

  /**
   * @expectedException sfValidatorError
   */
  public function testClean_YearOnly_Throws()
  {
    $date = array(
      'year' => '2010',
    );

    $this->validator->clean($date);
  }

  /**
   * @expectedException sfValidatorError
   */
  public function testClean_ZeroMonth_Throws()
  {
    $date = array(
      'year' => '2010',
      'month' => '00',
    );

    $this->validator->clean($date);
  }

  /**
   * @expectedException sfValidatorError
   */
  public function testClean_ThirteenMonth_Throws()
  {
    $date = array(
      'year' => '2010',
      'month' => '13',
    );

    $this->validator->clean($date);
  }

  public function testClean_SingleDigitMonth_Cleans()
  {
    $date = array(
      'year' => '2010',
      'month' => '1',
    );

    $this->assertEquals('2010-01', $this->validator->clean($date));
  }
}

