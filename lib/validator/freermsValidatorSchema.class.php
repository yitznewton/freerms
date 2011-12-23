<?php

class freermsValidatorSchema extends sfValidatorSchema
{
  /**
   * This causes the validation to halt if prevalidation or main validation
   * fails.
   *
   * @see http://trac.symfony-project.org/ticket/7343
   * @param $values
   * @return array The fixed values
   */
  protected function doClean($values)
  {
    if (null === $values)
    {
      $values = array();
    }

    if (!is_array($values))
    {
      throw new InvalidArgumentException('You must pass an array parameter to the clean() method');
    }

    $clean  = array();
    $unused = array_keys($this->fields);
    $errorSchema = new sfValidatorErrorSchema($this);

    // check that post_max_size has not been reached
    if (isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > $this->getBytes(ini_get('post_max_size')))
    {
      $errorSchema->addError(new sfValidatorError($this, 'post_max_size'));

      throw $errorSchema;
    }

    // pre validator
    try
    {
      $this->preClean($values);
    }
    catch (sfValidatorErrorSchema $e)
    {
      $errorSchema->addErrors($e);
    }
    catch (sfValidatorError $e)
    {
      $errorSchema->addError($e);
    }

    if (count($errorSchema))
    {
      throw $errorSchema;
    }
    
    // validate given values
    foreach ($values as $name => $value)
    {
      // field exists in our schema?
      if (!array_key_exists($name, $this->fields))
      {
        if (!$this->options['allow_extra_fields'])
        {
          $errorSchema->addError(new sfValidatorError($this, 'extra_fields', array('field' => $name)));
        }
        else if (!$this->options['filter_extra_fields'])
        {
          $clean[$name] = $value;
        }

        continue;
      }

      unset($unused[array_search($name, $unused, true)]);

      // validate value
      try
      {
        $clean[$name] = $this->fields[$name]->clean($value);
      }
      catch (sfValidatorError $e)
      {
        $clean[$name] = null;

        $errorSchema->addError($e, (string) $name);
      }
    }

    // are non given values required?
    foreach ($unused as $name)
    {
      // validate value
      try
      {
        $clean[$name] = $this->fields[$name]->clean(null);
      }
      catch (sfValidatorError $e)
      {
        $clean[$name] = null;

        $errorSchema->addError($e, (string) $name);
      }
    }

    if (count($errorSchema))
    {
      throw $errorSchema;
    }

    // post validator
    try
    {
      $clean = $this->postClean($clean);
    }
    catch (sfValidatorErrorSchema $e)
    {
      $errorSchema->addErrors($e);
    }
    catch (sfValidatorError $e)
    {
      $errorSchema->addError($e);
    }

    if (count($errorSchema))
    {
      throw $errorSchema;
    }

    return $clean;
  }
}
