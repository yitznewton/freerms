<?php

/**
 * ipregevent actions.
 *
 * @package    freerms
 * @subpackage ipregevent
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ipregeventActions extends sfActions
{
  public function executeDelete(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->add( IpRegEventPeer::IP_RANGE_ID, $request->getParameter( 'id' ) );

    IpRegEventPeer::doDelete( $c );

    $this->redirect( 'ip/registration' );
  }

  public function executeAutoregister(sfWebRequest $request)
  {
    $from    = sfConfig::get('app_autoregister_from');
    $subject = sfConfig::get('app_autoregister_subject', 'IP update');

    if ( ! $from ) {
      throw new Exception('sender email address not found');
    }

    $organizations = OrganizationPeer::retrieveHavingIpRegEvents();

    foreach ( $organizations as $organization ) {
      if ( $organization->getIpRegMethod()->getLabel() != 'auto email' ) {
        continue;
      }

      $contact = $organization->getContact();

      if ( ! $contact || ! $contact->getFirstContactEmail() ) {
        continue;
      }

      $to      = $contact->getFirstContactEmail();
      $body    = $this->composeEmailBody( $organization );

      // FIXME: echo for testing
      echo($body);
      return;
      
      $this->getMailer()->composeAndSend(
        $from,
        $to,
        $subject,
        $body
      );
    }
  }

  protected function composeEmailBody( Organization $organization )
  {
    $attributes = array(
      'organization'  => $organization,
      'contact'       => $organization->getContact(),
      'ip_reg_events' => $organization->getIpRegEvents(),
    );

    $view = new sfPHPView( $this->getContext(), 'ipregevent', 'emailBody', 'Success' );

    $view->execute();
    $view->getAttributeHolder()->add( $attributes );

    $output = $view->render();

    return $output;
  }

}
