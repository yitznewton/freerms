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
       
        $this->getUser()->setAuthenticated(true);

        $referer = $this->getUser()->getReferer();

        $this->redirect($referer);
      }
      else {
        $this->form = $form;
      }
    }

    else {
      $this->form = new LoginForm();
      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $this->getUser()->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());
    }    
  }

  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->clear();
    $this->getUser()->setAuthenticated(false);
    $this->redirect('@homepage');
  }

}
