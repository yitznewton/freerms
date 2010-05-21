<?php

require_once dirname(__FILE__).'/../lib/organizationGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/organizationGeneratorHelper.class.php';

/**
 * organization actions.
 *
 * @package    freerms
 * @subpackage organization
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class organizationActions extends autoOrganizationActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new OrganizationForm();
    $this->eresources = null;
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($organization = OrganizationPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $this->form = new OrganizationForm($organization);

    $this->eresources_vendor = EResourcePeer::retrieveByVendorOrgId($request->getParameter('id'));

    $this->contacts = ContactPeer::retrieveByOrgId($request->getParameter('id'));

  }
}
