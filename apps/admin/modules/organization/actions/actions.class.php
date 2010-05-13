<?php

/**
 * organization actions.
 *
 * @package    freerms
 * @subpackage organization
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class organizationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(OrganizationPeer::NAME);

    $this->organizations = OrganizationPeer::doSelect( $c );
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new OrganizationForm();
    $this->eresources = null;
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new OrganizationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($organization = OrganizationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $this->form = new OrganizationForm($organization);

    $this->eresources_vendor = EResourcePeer::retrieveByVendorOrgId($request->getParameter('id'));

    $this->contacts = ContactPeer::retrieveByOrgId($request->getParameter('id'));

  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($organization = OrganizationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $this->form = new OrganizationForm($organization);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($organization = OrganizationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $library->delete();

    $this->redirect('organization/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $organization = $form->save();

      $this->redirect('organization/edit?id='.$organization->getId());
    }
  }
}
