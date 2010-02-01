<?php

class LoginForm extends sfForm
{
  protected $module;
  protected $action;

  public function setup()
  {
    $this->setWidgets( array(
      'username' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(),
    ) );

    $this->setValidators( array(
      // FIXME set correct values
      'username' => new sfValidatorString( array('min_length' => 6, 'required' => true ) ),
      'password' => new sfValidatorString( array('min_length' => 6, 'required' => true ) ),
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

  public function doPostValidate( sfValidatorBase $validator, array $values )
  {
    if (
      empty( $values['username'] )
      || empty( $values['password'] )
    ) {
      return;
    }

    $user = sfContext::getInstance()->getUser();
    $user->setUsername( $values['username'] );
    
    if ( $user->checkPassword( $values['password'] ) ) {
      return $values;
    }
    else {
      $msg = 'Your username and password did not match any accounts '
             . 'in our database; please try again.';
      
      throw new sfValidatorError( $validator, $msg );
    }
  }
}
