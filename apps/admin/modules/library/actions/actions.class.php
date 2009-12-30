<?php

/**
 * library actions.
 *
 * @package    erms
 * @subpackage library
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class libraryActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(LibraryPeer::NAME);
    
    $this->library_list = LibraryPeer::doSelect($c);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new LibraryForm();

    $this->ips = IpRangePeer::retrieveIpsByLibraryId(1);
    $this->eresources = null;
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new LibraryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($library = LibraryPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $this->form = new LibraryForm($library);
    
    $this->ips = IpRangePeer::retrieveIpsByLibraryId($request->getParameter('id'));
    $this->eresources = EResourcePeer::retrieveByLibraryId($request->getParameter('id')); 
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($library = LibraryPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $this->form = new LibraryForm($library);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($library = LibraryPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $library->delete();

    $this->redirect('library/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $library = $form->save();

      $this->redirect('library/edit?id='.$library->getId());
    }
  }
}
