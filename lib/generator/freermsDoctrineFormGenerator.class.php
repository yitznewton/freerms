<?php
/**
 */

/**
 * This class is to reference the modified freermsValidatorString
 * which fixes the symfony feature/bug of empty_value
 *
 * @see freermsValidatorString
 * @see http://trac.symfony-project.org/ticket/4226
 */
class freermsDoctrineFormGenerator extends sfDoctrineFormGenerator
{
  /**
   * Returns a sfValidator class name for a given column.
   *
   * @param sfDoctrineColumn $column
   * @return string    The name of a subclass of sfValidator
   */
  public function getValidatorClassForColumn($column)
  {
    switch ($column->getDoctrineType())
    {
      case 'boolean':
        $validatorSubclass = 'Boolean';
        break;
      case 'string':
    		if ($column->getDefinitionKey('email'))
    		{
    		  $validatorSubclass = 'Email';
    		}
    		else if ($column->getDefinitionKey('regexp'))
    		{
    		  $validatorSubclass = 'Regex';
    		}
    		else
    		{
    		  return 'freermsValidatorString';
    		}
        break;
      case 'clob':
      case 'blob':
        return 'freermsValidatorString';
      case 'float':
      case 'decimal':
        $validatorSubclass = 'Number';
        break;
      case 'integer':
        $validatorSubclass = 'Integer';
        break;
      case 'date':
        $validatorSubclass = 'Date';
        break;
      case 'time':
        $validatorSubclass = 'Time';
        break;
      case 'timestamp':
        $validatorSubclass = 'DateTime';
        break;
      case 'enum':
        $validatorSubclass = 'Choice';
        break;
      default:
        $validatorSubclass = 'Pass';
    }

    if ($column->isForeignKey())
    {
      $validatorSubclass = 'DoctrineChoice';
    }
    else if ($column->isPrimaryKey())
    {
      $validatorSubclass = 'Choice';
    }

    return sprintf('sfValidator%s', $validatorSubclass);
  }
}

