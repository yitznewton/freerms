<?php

class freermsValidatorYaml extends sfValidatorBase
{
  protected function doClean($value)
  {
    if (!is_string($value)) {
      throw new sfValidatorError($this, 'invalid');
    }
    
    $value = trim($value);

    try {
      $yaml = sfYaml::load($value);
    }
    catch (InvalidArgumentException $e) {
      throw new sfValidatorError($this, 'invalid');
    }

    return $value;
  }
}

