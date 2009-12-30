<?php

/**
 * subject actions.
 *
 * @package    freerms
 * @subpackage subject
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class subjectActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(DbSubjectPeer::LABEL);
	
    $this->db_subject_list = DbSubjectPeer::doSelect($c);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DbSubjectForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new DbSubjectForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($db_subject = DbSubjectPeer::retrieveByPk($request->getParameter('id')), sprintf('Object db_subject does not exist (%s).', $request->getParameter('id')));
    $this->form = new DbSubjectForm($db_subject);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($db_subject = DbSubjectPeer::retrieveByPk($request->getParameter('id')), sprintf('Object db_subject does not exist (%s).', $request->getParameter('id')));
    $this->form = new DbSubjectForm($db_subject);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($db_subject = DbSubjectPeer::retrieveByPk($request->getParameter('id')), sprintf('Object db_subject does not exist (%s).', $request->getParameter('id')));
    $db_subject->delete();

    $this->redirect('subject/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $db_subject = $form->save();

      $this->redirect('subject/edit?id='.$db_subject->getId());
    }
  }
}
