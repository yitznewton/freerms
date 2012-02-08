<?php

require_once dirname(__FILE__).'/../lib/databaseGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/databaseGeneratorHelper.class.php';

/**
 * database actions.
 *
 * @package    freerms
 * @subpackage database
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class databaseActions extends autoDatabaseActions
{
  public function executeClone(sfWebRequest $request)
  {
    if ($clone_from_id = $request->getParameter('clone_from_id')) {
      $parent_database = Doctrine_Core::getTable('Database')
        ->find($clone_from_id);

      $this->forward404Unless($parent_database);
    }

    $this->database = $parent_database->copy();
    $this->form     = new DatabaseForm($this->database);

    $this->setTemplate('new');
  }
  
  public function executeHomepageFeatured(sfWebRequest $request)
  {
    if ($request->hasParameter('Database')) {
      foreach ($request->getParameter('Database') as $databaseValues) {
        if (
          !isset($databaseValues['id'])
          || !isset($databaseValues['featured_weight'])
        ) {
          continue;
        }

        $database = Doctrine_Core::getTable('Database')
          ->find($databaseValues['id']);

        if ($database) {
          $database->setFeaturedWeight($databaseValues['featured_weight']);
          $database->save();
        }
      }
    }

    $this->form = new FeaturedDatabaseListForm();
  }

  public function executeRemoveSubject(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    $ds = Doctrine_Core::getTable('DatabaseSubject')->find(
      array($request->getParameter('database_id'),
        $request->getParameter('subject_id')));

    $this->forward404Unless($ds);

    $ds->delete();

    $this->getResponse()->setContentType('application/json');
    $this->getResponse()->setContent('{}');

    return sfView::NONE;
  }
}

