<?php
/*
 * for Essential Evidence Plus
 */
class AccessInfo508AccessHandler extends EZproxyAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  
  public function execute()
  {
    if ( ! $this->action->getUser()->isAuthenticated() ) {
      $this->action->forward(
        sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action') );

      return;
    }
    
    $program = $this->action->getUser()->getProgramCode();
    
    if ( ! in_array( $program, array('HS PA ','HS PAM') )) {
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
