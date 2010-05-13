<?php

/**
 * contact actions.
 *
 * @package    freerms
 * @subpackage contact
 * @author     Your name here
 */
class contactActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->Contacts = ContactPeer::doSelect(new Criteria());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ContactForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ContactForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Contact = ContactPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Contact does not exist (%s).', $request->getParameter('id')));
    $this->form = new ContactForm($Contact);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Contact = ContactPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Contact does not exist (%s).', $request->getParameter('id')));
    $this->form = new ContactForm($Contact);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Contact = ContactPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Contact does not exist (%s).', $request->getParameter('id')));
    $Contact->delete();

    $this->redirect('contact/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Contact = $form->save();

      $this->redirect('contact/edit?id='.$Contact->getId());
    }
  }
}