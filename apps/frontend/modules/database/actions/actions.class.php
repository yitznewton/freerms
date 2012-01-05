<?php

/**
 * database actions.
 *
 * @package    freerms
 * @subpackage database
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class databaseActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $subjectSlug = $request->getParameter('subject');

    if ($subjectSlug) {
      $this->subject = Doctrine_Core::getTable('Subject')
        ->findOneBySlug($subjectSlug);
    }
    else {
      $this->subject = null;
    }

    $libraryIds = $this->getContext()->getAffiliation()->getLibraryIds();

    $databaseTable = Doctrine_Core::getTable('Database');

    if ($this->subject) {
      $this->featuredDatabases = $databaseTable
        ->findFeaturedByLibraryIdsAndSubject($libraryIds, $this->subject);
    }
    else {
      // TODO: general (non-subject) featured dbs
      $this->featuredDatabases = array();
    }

    $this->subjectDefault = $subjectSlug;
    $this->subjectWidget  = new SubjectWidgetFormChoice();

    $this->databases = $databaseTable->findByLibraryIds($libraryIds);

    return sfView::SUCCESS;
  }
}

