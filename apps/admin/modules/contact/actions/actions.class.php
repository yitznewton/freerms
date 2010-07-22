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
    $c = new Criteria();
    $c->addAscendingOrderByColumn(ContactPeer::LAST_NAME);
    $c->addAscendingOrderByColumn(ContactPeer::FIRST_NAME);
    
    $this->Contacts = ContactPeer::doSelect($c);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ContactForm();

    if ( $org_id = $request->getParameter('organization') ) {
      $this->form->setDefault('org_id', $request->getParameter('organization'));
    }    
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

  public function executeAddSubform($request)
  {
    $this->forward404unless($request->isXmlHttpRequest());
    
    $type      = $request->getParameter('type');
    $container = $type . 's';
    
    $index = intval($request->getParameter('index'));

    $contact = ContactPeer::retrieveByPk($request->getParameter('id'));
    
    if ($contact) {
      $form = new ContactForm($contact);
    }
    else {
      $form = new ContactForm();
    }

    $form->addSubformContainer( $type, $index );

    return $this->renderPartial('addSubform', array('subform' => $form[$container][$index]));
  }

  public function executeDeleteContactEmail(sfWebRequest $request)
  {   
    $email = ContactEmailPeer::retrieveByPk($request->getParameter('id'));  
    $email->delete();
    
    $this->redirect('contact/edit?id='.$email->getContact()->getId());
  }

  public function executeDeleteContactPhone(sfWebRequest $request)
  {
    $phone = ContactPhonePeer::retrieveByPk($request->getParameter('id'));
    $phone->delete();

    $this->redirect('contact/edit?id='.$phone->getContact()->getId());
  }
}
