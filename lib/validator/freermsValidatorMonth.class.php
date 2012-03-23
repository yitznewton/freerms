<?php

class freermsValidatorMonth extends sfValidatorDate
{
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    $this->setOption('with_time', false);
    $this->setOption('date_output', 'Y-m');
  }

  protected function doClean($value)
  {
    if (!is_array($value)) {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    return parent::doClean($value);
  }

  protected function convertDateArrayToString($value)
  {
    // all elements must be empty or a number
    foreach (array('year', 'month', 'day', 'hour', 'minute', 'second') as $key)
    {
      if (isset($value[$key]) && !preg_match('#^\d+$#', $value[$key]) && !empty($value[$key]))
      {
        throw new sfValidatorError($this, 'invalid', array('value' => $value));
      }
    }

    // if one date value is empty, all others must be empty too
    $empties =
      (!isset($value['year']) || !$value['year'] ? 1 : 0) +
      (!isset($value['month']) || !$value['month'] ? 1 : 0)
    ;
    if ($empties > 0 && $empties < 2)
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }
    else if (2 == $empties)
    {
      return $this->getEmptyValue();
    }

    if (!checkdate(intval($value['month']), 1, intval($value['year'])))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    $clean = sprintf(
      "%04d-%02d",
      intval($value['year']),
      intval($value['month'])
    );

    return $clean;
  }
}

