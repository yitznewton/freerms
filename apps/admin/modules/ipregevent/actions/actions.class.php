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
}
