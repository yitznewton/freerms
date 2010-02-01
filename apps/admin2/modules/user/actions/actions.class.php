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
        // TODO set user to authenticated and redirect to desired page
      }
      else {
        // form not valid - redisplay
        $this->form = $form;
      }
    }
    else {
      // not a POST or PUT - display blank form
      $this->form = new LoginForm();
    }
  }

}
