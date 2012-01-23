<?php
/*
* This file is part of the symfony package.
* (c) Fabien Potencier <fabien.potencier@symfony-project.com>
* (c) Kevin Cyster <kcyster@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
/**
* sfValidatorDoctrineEnum validates than the value is one of the model's column ENUM values.
*
* @package    symfony
* @subpackage validator
* @author     Fabien Potencier <fabien.potencier@symfony-project.com>
* @author     Kevin Cyster@gmail.com
*/
class sfValidatorDoctrineEnum extends sfValidatorChoice
{
  /**
   * Configures the current validator.
   *
   * Available options:
   *
   * Available options:
   *
   *  * model:        The model class (required)
   *  * column:       The ENUM column of the model class (required)
   *
   * @see sfValidatorBase
   * @see http://forum.symfony-project.org/viewtopic.php?f=22&t=26873
   * @param array $options    An array of options
   * @param array $messages   An array of error messages
   * @return VOID
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('table');
    $this->addRequiredOption('column');

    $columnDefinition = $options['table']
      ->getColumnDefinition($options['column']);

    if (
      isset($columnDefinition['notnull'])
      && $columnDefinition['notnull'] === true
    ) {
      $this->options['required'] = true;
    }
    else {
      $this->options['required'] = false;
    }
  }

  /**
   * Method to return the enum choices of a column
   *
   * @return array $choices The enum values of the column
   */
  public function getChoices()
  {
    $choices = array();

    $enumValues = $this->getOption('table')
      ->getEnumValues($this->getOption('column'));

    $choices = array_combine($enumValues, $enumValues);

    return $choices;
  }
}

