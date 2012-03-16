<?php

require_once dirname(__FILE__).'/../lib/libraryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/libraryGeneratorHelper.class.php';

/**
 * library actions.
 *
 * @package    freerms
 * @subpackage library
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libraryActions extends autoLibraryActions
{
  public function postExecute()
  {
    if (isset($this->library)) {
      $this->databases = Doctrine_Core::getTable('Database')->createQuery('d')
        ->leftJoin('d.Libraries l')
        ->where('l.id = ?', $this->library->getId())
        ->orderBy('d.sort_title')
        ->execute();
    }
    else {
      $this->databases = array();
    }
  }
}

