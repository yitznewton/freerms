<?php

/**
 * Database
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    freerms
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Database extends BaseDatabase
{
  /**
   * Returns truncated string for use in Choice widget
   *
   * @return string
   */
  public function toStringForWidget()
  {
    if (strlen($this->__toString()) < 26) {
      return $this->__toString();
    }
    else {
      return substr($this->__toString(), 0, 22) . '...';
    }
  }

  /**
   * @return array int[]
   */
  public function getLibraryIds()
  {
    $ids = array();

    foreach ($this->getLibraries() as $library) {
      $ids[] = $library->getId();
    }

    return $ids;
  }

  /**
   * @return array
   */
  public function getAdditionalFieldsArray()
  {
    if (!is_string($this->getAdditionalFields())) {
      // TODO: evaluate whether this is really the best way of handling this
      // edge case, which "should never happen" because of form validation
      return null;
    }

    return sfYaml::load($this->getAdditionalFields());
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function getAdditionalField($name)
  {
    if (!is_string($name)) {
      throw new InvalidArgumentException('name must be a string');
    }

    $fields = $this->getAdditionalFieldsArray();

    return isset($fields[$name]) ? $fields[$name] : null;
  }

  /**
   * @return array
   */
  public function getAccessControlArray()
  {
    $munged     = 'control: ' . trim($this->getAccessControl());
    $yaml_array = sfYaml::load($munged);

    if (!$yaml_array) {
      return array();
    }

    return $yaml_array['control'];
  }

  /**
   * Returns a copy of the Database with certain unique elements unset
   *
   * @param bool $deep whether to copy relations
   * @return Database
   */
  public function copy($deep = false)
  {
    $copy = parent::copy($deep);

    $copy->setLibraries($this->getLibraries());
    $copy->setSubjects($this->getSubjects());

    $copy->setAltId(null);

    return $copy;
  }
}

