<?php

class touroUsersValidatorUser extends sfGuardValidatorUser
{
  public function configure( $options = array(), $messages = array() )
  {
    parent::configure( $options, $messages );
    
    $this->addMessage('expired', 'It looks like your account is expired.');
  }
  
  protected function doClean($values)
  {
    // only validate if username and password are both present
    if (isset($values[$this->getOption('username_field')]) && isset($values[$this->getOption('password_field')]))
    {
      $username = $values[$this->getOption('username_field')];
      $password = $values[$this->getOption('password_field')];

      // user exists?
      if ($user = UserPeer::retrieveByUsername($username))
      {
        if ( ! $user->checkPassword( $password )) {
          throw new sfValidatorError($this, 'invalid');
        }
        
        if ( $user->isExpired() ) {
          throw new sfValidatorError($this, 'expired');
        }
        
        return array_merge($values, array('user' => $user));
      }

      if ($this->getOption('throw_global_error'))
      {
        throw new sfValidatorError($this, 'invalid');
      }

      throw new sfValidatorErrorSchema($this, array(
        $this->getOption('username_field') => new sfValidatorError($this, 'invalid'),
      ));
    }

    // assume a required error has already been thrown, skip validation
    return $values;
  }
}
