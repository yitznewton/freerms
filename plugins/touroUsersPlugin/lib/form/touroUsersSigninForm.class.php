<?php

class touroUsersSigninForm extends sfGuardFormSignin
{
  public function configure()
  {
    parent::configure();
    
    unset( $this['remember'] );
    
    $this->validatorSchema->setPostValidator(new touroUsersValidatorUser());
  }
}
