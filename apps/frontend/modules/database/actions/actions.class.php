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
    $libraryIds = $this->getContext()->getAffiliation()->getLibraryIds();

    $databaseTable = Doctrine_Core::getTable('Database');

    $this->subject           = null;
    $this->featuredDatabases = array();

    $subjectSlug = $request->getParameter('subject');

    if ($subjectSlug) {
      $subject = Doctrine_Core::getTable('Subject')
        ->findOneBySlug($subjectSlug);

      if ($subject) {
        $this->featuredDatabases = $databaseTable
          ->findFeaturedByLibraryIdsAndSubject($libraryIds, $subject);

        $this->subject = $subject;
      }
      else {
        // TODO: general (non-subject) featured dbs
      }
    }

    $this->subjectDefault = $subjectSlug;
    $this->subjectWidget  = new SubjectWidgetFormChoice();

    $this->databases = $databaseTable->findByLibraryIdsAndSubject(
      $libraryIds, $this->subject);

    return sfView::SUCCESS;
  }
}

