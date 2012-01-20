<?php
/*
* This file is part of the symfony package.
* (c) Fabien Potencier <fabien.potencier@symfony-project.com>
* (c) Jonathan H. Wage <jonwage@gmail.com>
* (c) Kevin Cyster <kcyster@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
/**
* sfWidgetFormDoctrineEnum represents a choice widget for an ENUM column in a model.
*
* @see        http://forum.symfony-project.org/viewtopic.php?f=22&t=26873
* @author     Fabien Potencier <fabien.potencier@symfony-project.com>
* @author     Jonathan H. Wage <jonwage@gmail.com>
* @author     Kevin Cyster <kcyster@gmail.com>
  */
class sfWidgetFormDoctrineEnum extends sfWidgetFormChoice
{
  /**
   * Constructs the current widget.
   *
   * Available options:
   *
   * Available options:
   *
   *  * model:        The model class (required)
   *  * column:       The ENUM column of the model class (required)
   *
   * @see sfWidget
   * @param array $options    An array of options
   * @param array $attributes   An array of error messages
   * @return VOID
   */
  public function __construct(array $options = array(), array $attributes = array())
  {
    // inherited required option
    $options['choices'] = array();

    parent::__construct($options, $attributes);
  }

  /**
   * Configures the current widget.
   *
   * Available options:
   *
   *  * table:        The Doctrine_Table object (required)
   *  * column:       The ENUM column of the model class (required)
   *  * add_empty:    Whether to add a first empty value or not (false by default)
   *                  If the option is not a Boolean, the value will be used as the text value
   *  * remove        An array of values to remove from the dropdown
   * 
   * @see sfWidgetFormSelect
   * @param array $options An array of options
   * @param array $attributes An array of attributes
   * @return VOID
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('table');
    $this->addRequiredOption('column');
    $this->addOption('remove_choices', array());

    parent::configure($options, $attributes);
  }

  /**
   * Returns the choices associated to ENUM column of the model.
   *
   * @return array An array of choices
   */
  public function getChoices()
  {
    $columnName = $this->getOption('column');

    $columnDefinition = $this->getOption('table')->getColumnDefinition(
      $columnName);

    $enumValues = $this->getOption('table')->getEnumValues($columnName);

    $choices = array();

    if (
      !isset($columnDefinition['notnull'])
      || $columnDefinition['notnull'] === false
    ) {
      $choices[''] = '';
    }

    foreach ($this->getOption('remove_choices') as $v) {
      $key = array_search($v, $enumValues);

      if ($key !== false) {
        unset($enumValues[$key]);
      }
    }

    return array_merge($choices, array_combine($enumValues, $enumValues));
  }
}

