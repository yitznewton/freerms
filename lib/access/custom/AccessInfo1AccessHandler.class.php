<?php
class AccessInfo1AccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  
  public function execute()
  {
    if ( ! $this->action->getUser()->getUsername() ) {
      $this->action->getUser()->logout();
      $this->action->getUser()->setFlash( 'force_login', true );
      $this->action->redirect( $_SERVER['REQUEST_URI'] );
    }

    $access_uri = $this->getAccessUri();

    if ( ! in_array( $this->action->getUser()->getProgram(), array('HS PA ','HS PAM') ) ) {
      throw new freermsUnauthorizedException();
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
