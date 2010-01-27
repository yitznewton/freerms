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

    BaseFormPropel::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  protected function doPostValidate( sfValidatorBase $validator, array $values )
  {
    $c = new Criteria();
    $c->add( FreermsPropelUserPeer::USERNAME, $values['username'] );
    $c->add( FreermsPropelUserPeer::PASSWORD, sha1( $values['password'] ) );

    $user = FreermsPropelUserPeer::doSelectOne( $c );
    var_dump($user);exit;
  }
}
