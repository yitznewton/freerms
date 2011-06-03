<?php

class touroUsersSigninForm extends sfGuardFormSignin
{
  public function configure()
  {
    parent::configure();
    
    $this->validatorSchema->setPostValidator(new touroUsersValidatorUser());
  }
}
