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
    
    switch ( $request->getParameter('type') ) {
      case 'Email':
        $method    = 'addEmail';
        $container = 'emails';
        break;
      
      case 'Phone':
        $method    = 'addPhone';
        $container = 'phones';
        break;
      
      default:
        $this->forward404();
    }
    
    $index = intval($request->getParameter('index'));

    $contact = ContactPeer::retrieveByPk($request->getParameter('id'));
    
    if ($contact){
      $form = new ContactForm($contact);
    }
    else {
      $form = new ContactForm();
    }

    $form->$method($index);

    return $this->renderPartial('addSubform', array('form' => $form, 'container' => $container, 'index' => $index));
  }

  public function executeDeleteEmail(sfWebRequest $request)
  {   
    $email = ContactEmailPeer::retrieveByPk($request->getParameter('id'));  
    $email->delete();
    
    $this->redirect('contact/edit?id='.$email->getContact()->getId());
  }

  public function executeDeletePhone(sfWebRequest $request)
  {
    $phone = ContactPhonePeer::retrieveByPk($request->getParameter('id'));
    $phone->delete();

    $this->redirect('contact/edit?id='.$phone->getContact()->getId());
  }
}
