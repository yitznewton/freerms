<?php
/**
 */

/**
 * This class is to reference the modified freermsValidatorString
 * which fixes the symfony feature/bug of empty_value
 *
 * @see freermsDoctrineFormGenerator
 * @see http://trac.symfony-project.org/ticket/4226
 */
class freermsValidatorString extends sfValidatorString
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addMessage('max_length', '"%value%" is too long (%max_length% characters max).');
    $this->addMessage('min_length', '"%value%" is too short (%min_length% characters min).');

    $this->addOption('max_length');
    $this->addOption('min_length');
  }
}

