<?php

/**
 * Project form base class.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormBaseTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
abstract class BaseFormPropel extends sfFormPropel
{
  public function setup()
  {
    foreach ($this->validatorSchema->getFields() as $v) {
      if ($v instanceOf sfValidatorString) {
        $v->setOption('empty_value', null);
      }
    }
  }
}
