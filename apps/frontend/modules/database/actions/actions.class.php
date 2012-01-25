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
   * @param sfWebRequest $request A request object
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
    }

    if (!$this->subject) {
      $this->featuredDatabases = $databaseTable
        ->findGeneralFeaturedByLibraryIds($libraryIds);
    }

    $this->subjectDefault = $subjectSlug;
    $this->subjectWidget  = new WidgetFormChoiceSubject(
      array('library_ids' => $libraryIds));

    $this->databases = $databaseTable->findByLibraryIdsAndSubject(
      $libraryIds, $this->subject);

    return sfView::SUCCESS;
  }

  /**
   * @param sfWebRequest $request A request object
   */
  public function executeAccess(sfWebRequest $request)
  {
    $database = Doctrine_Core::getTable('Database')
      ->find($request->getParameter('id'));

    $this->forward404Unless($database);
    $this->forward404If($database->getIsUnavailable());

    if ($this->getContext()->getAffiliation()->isOnsite()) {
      $action = $database->getAccessActionOnsite();
    }
    else {
      $action = $database->getAccessActionOffsite();
    }

    $user = $this->getUser();

    $user->setFlash('database_id', $database->getId());
    $user->setFlash('database_title', $database->getTitle());
    $user->setFlash('database_library_ids', $database->getLibraryIds());
    $user->setFlash('database_url', $database->getAccessUrl());
    $user->setFlash('referral_note', $database->getReferralNote());

    if ($action == 'refererAccess') {
      $this->redirect('@access_refer');
    }

    // symfony handles nonexistent actions
    $this->forward('access', $action);
  }
}

