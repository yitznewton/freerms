<?php
class AccessInfo1AccessHandler extends ScriptAccessHandler
{
  public function execute()
  {
    if ( ! $this->action->getUser()->getUsername() ) {
      $this->action->getUser()->logout();
      $this->action->getUser()->setFlash( 'force_login', true );
      $this->action->redirect( $_SERVER['REQUEST_URI'] );
    }

    $access_uri = $this->getAccessUri();

    if ( ! in_array( $this->action->getUser()->getProgram(), array('HS PA ','HS PAM') ) ) {
      $this->action->setTemplate('unauthorized');
      return;
    }

    if ( $this->isOnsite ) {
      $this->action->redirect( $access_uri );
      return;
    }
    else {
      $library = LibraryPeer::retrieveByPK($user_affiliation[0]);
      $proxy_uri = freermsEZproxy::getEZproxyTicketUrl(
        $library, $access_uri, $this->action->getUser()->getAttribute('username')
      );
      $this->action->redirect($proxy_uri);
      return;
    }
  }
}
