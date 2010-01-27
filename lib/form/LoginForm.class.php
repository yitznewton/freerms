<?php

class LoginForm extends sfForm
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

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $decorator->setRowFormat(
      "<div class=\"login-form\">\n  %error%%label%"
      ."\n  %field%%help%\n%hidden_fields%</div>\n"
    );
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');
  }

  protected function doPostValidate( sfValidatorBase $validator, array $values )
  {
    $user = sfContext::getInstance()->getUser();
    var_dump($user);exit;
    $user->setUsername( $values['username'] );
    
    if ( $user->checkPassword( $values['password'] ) ) {
      return $values;
    }
    else {
      throw new sfValidatorError( 'no way' );
    }
  }


}
