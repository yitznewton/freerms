<?php

/**
 * ip actions.
 *
 * @package    freerms
 * @subpackage ip
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ipActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    switch ($request->getParameter('sort')) {
      case 'start-ip':
        $c->addAscendingOrderByColumn(IpRangePeer::START_IP);
        break;
      case 'library':
        $c->addJoin(IpRangePeer::LIB_ID, LibraryPeer::ID);
        $c->addAscendingOrderByColumn(LibraryPeer::NAME);
        break;
      default:
        $c->addAscendingOrderByColumn(IpRangePeer::PROXY_INDICATOR);
        $c->addAscendingOrderByColumn(IpRangePeer::START_IP);
    }
    
    $this->ip_range_list = IpRangePeer::doSelectJoinLibrary($c);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->getUser()->setFlash('referer', $request->getReferer());

    $this->form = new IpRangeForm();
    
    if ( $lib_id = $request->getParameter('library') ) {
      $this->form->setDefault('lib_id', $request->getParameter('library')); 
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new IpRangeForm();
    
    $this->processForm($request, $this->form);
    
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->getUser()->setFlash('referer', $request->getReferer());
    
    $this->forward404Unless($ip_range = IpRangePeer::retrieveByPk($request->getParameter('id')), sprintf('Object ip_range does not exist (%s).', $request->getParameter('id')));
    $this->form = new IpRangeForm($ip_range);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($ip_range = IpRangePeer::retrieveByPk($request->getParameter('id')), sprintf('Object ip_range does not exist (%s).', $request->getParameter('id')));
    $this->form = new IpRangeForm($ip_range);

    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($ip_range = IpRangePeer::retrieveByPk($request->getParameter('id')), sprintf('Object ip_range does not exist (%s).', $request->getParameter('id')));
    $lib_id = $ip_range->getLibId();
    $ip_range->delete();

    $this->redirect('library/edit?id='.$lib_id.'#ip-ranges');
  }

  public function executeRegistration(sfWebRequest $request)
  {
    $organization_array = array();

    $organizations = OrganizationPeer::retrieveHavingIpRegEvents();
    $this->ip_reg_events = IpRegEventPeer::retrieveAll();

    foreach ( $organizations as $organization ) {
      $contact       = $organization->getContact();
      
      $current                  = array();
      $current['organization']  = $organization;
      $current['contact']       = $contact;
      $current['ip_reg_events'] = $organization->getIpRegEvents();

      switch ( $organization->getIpRegMethod()->getLabel() ) {
        case 'auto email':
          if ( $contact && $contact->getFirstContactEmail() ) {
            $organization_array['auto email'][ $organization->getName() ] = $current;
          }
          else {
            $organization_array['other'][ $organization->getName() ] = $current;
          }

          break;

        case 'manual email':
          if ( $contact && $contact->getFirstContactEmail() ) {
            $organization_array['manual email'][ $organization->getName() ] = $current;
          }
          else {
            $organization_array['other'][ $organization->getName() ] = $current;
          }

          break;

        case 'phone':
          if ( $contact && ( $contact->getFirstContactPhone() || $organization->getPhone() ) ) {
            $organization_array['phone'][ $organization->getName() ] = $current;
          }
          else {
            $organization_array['other'][ $organization->getName() ] = $current;
          }

          break;

        case 'web contact form':
          if ( $organization->getWebAdminUri() ) {
            $organization_array['web contact form'][ $organization->getName() ] = $current;
          }
          else {
            $organization_array['other'][ $organization->getName() ] = $current;
          }
          break;

        case 'web admin':
          if ( $organization->getWebAdminUri() ) {
            $organization_array['web admin'][ $organization->getName() ] = $current;
          }
          else {
            $organization_array['other'][ $organization->getName() ] = $current;
          }
          break;

        default:
          $organization_array['other'][ $organization->getName() ] = $current;
          break;
      }
    }

    $this->organizations = $organization_array;
  }

  public function executeAutoregister(sfWebRequest $request)
  {
    
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $ip_range = $form->save();

      //if (strpos($this->getUser()->getFlash('referer'), 'library/edit') !== false) {
        $this->redirect('library/edit?id='.$ip_range->getLibId().'#ip-ranges');
      //}
    }
  }
}
