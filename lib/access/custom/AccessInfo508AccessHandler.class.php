<?php
/*
 * for Essential Evidence Plus
 */
class AccessInfo508AccessHandler extends EZproxyAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const FORCE_AUTH_ONSITE = true;
  
  public function execute()
  {
    if ( ! in_array( $this->action->getUser()->getProgramCode(), array('HS PA ','HS PAM') )) {
      throw new freermsUnauthorizedException();
    }

    $access_uri = $this->getAccessUri();

    if ( $this->isOnsite ) {
      $this->action->redirect( $access_uri );
      return;
    }
    else {
      parent::execute();  // pass to EZproxy
      return;
    }
  }
}
