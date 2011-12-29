<?php

/**
 * library module configuration.
 *
 * @package    freerms
 * @subpackage library
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libraryGeneratorConfiguration extends BaseLibraryGeneratorConfiguration
{
  public function getForm($object = null, $options = array())
  {
    if (!$object) {
      $object = new Library();
    }

    extract(sfConfig::get('app_library-doctrine-listener'),
      EXTR_PREFIX_ALL, 'l');

    $object->addListener(new $l_class());

    return new LibraryForm($object,
      array_merge($this->getFormOptions(), $options));
  }
}
