<?php

class userActions extends sfActions
{
  public function executeLogin( sfWebRequest $request )
  {
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect('@homepage');
    }

    if ( $request->isMethod('post') || $request->isMethod('put') ) {
      $form = new LoginForm();
      $form->bind( $request->getParameter( $form->getName() ) );

      if ( $form->isValid() ) {

      }
    }

    $this->form = new LoginForm();
  }

}
