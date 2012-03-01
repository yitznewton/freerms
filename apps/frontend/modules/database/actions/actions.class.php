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
    // queries for freerms_database delegated to components to simplify
    // caching based on subject and library IDs

    $this->libraryIds = $this->getContext()->getAffiliation()->getLibraryIds();

    $this->subject = null;

    $subjectSlug = $request->getParameter('subject');

    if ($subjectSlug) {
      $this->subject = Doctrine_Core::getTable('Subject')
        ->findOneBySlug($subjectSlug);

      if ($this->subject === false) {
        // must be null or Subject; findOneBySlug() returns false if no match
        $this->subject = null;
      }
    }

    $this->subjectDefault = $subjectSlug;
    $this->subjectWidget  = new WidgetFormChoiceSubject(
      array('library_ids' => $this->libraryIds));

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

    try {
      $user->setFlash('database_access_control',
        $database->getAccessControlArray());
    }
    catch (InvalidArgumentException $e) {
      // failed YAML parse: ignore, allowing access and logging an error
      $this->logMessage($e->getMessage(), 'err');
    }

    $user->setFlash('referral_note', $database->getReferralNote());

    if ($action == 'refererAccess') {
      $url = preg_replace('/^https/', 'http',
        $this->getController()->genUrl('@access_refer', true));

      $this->redirect($url);
    }

    // symfony handles nonexistent actions
    $this->forward('access', $action);
  }
}

