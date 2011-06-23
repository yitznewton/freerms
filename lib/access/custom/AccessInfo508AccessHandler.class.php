<?php
/*
 * for Essential Evidence Plus
 */
class AccessInfo508AccessHandler extends EZproxyAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  
  public function execute( sfAction $action )
  {
    if ( ! $action->getUser()->isAuthenticated() ) {
      $action->forward(
        sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action') );

      return;
    }
    
    $program = $action->getUser()->getProgramCode();
    
    if ( ! in_array( $program, array('HS PA ','HS PAM') )) {
      throw new freermsUnauthorizedException();
    }

    $access_uri = $this->getAccessUri();

    EZproxyAccessHandler::execute( $action );  // pass to EZproxy
    return;
  }
}
