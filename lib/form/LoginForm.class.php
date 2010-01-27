<?php

class LoginForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets( array(
      'username' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(),
    ) );

    $this->setValidators( array(
      'username' => new sfValidatorString(),
      'password' => new sfValidatorString(),
    ) );

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback( array('callback' => array( $this, 'doPostValidate' ) ) )
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema( $this->validatorSchema );
  }

  public function getModelName()
  {
    return 'User';
  }

  protected function doPostValidate( sfValidatorBase $validator, array $values )
  {
    $user = sfContext::getInstance()->getUser();
    $user->setUsername( $values['username'] );
    
    if ( $user->checkPassword( $values['password'] ) ) {
      return $values;
    }
    else {
      throw new sfValidatorError( 'no way' );
    }
  }
}
