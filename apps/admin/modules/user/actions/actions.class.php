<?php

/**
 * user actions.
 *
 * @package    freerms
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogin(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect('@homepage');
    }
    
    $username = $request->getParameter('username');
    $password = $request->getParameter('password');

    $this->username = $request->getParameter('username');
    $this->errors = array();
    
    if ($request->getMethod() == 'POST') {
      // process submitted form
      
      // only attempt authentication if sanity check passed
      if ( ! is_string($username) || strlen($username) < 1 ) {
        $this->errors[] = 'Username must be a non-empty string';
      }
      
      if ( ! is_string($password) || strlen($password) < 1 ) {
        $this->errors[] = 'Password must be a non-empty string';
      }
      
      if (! $this->errors ) {
        $this->getUser()->setUsername($username);
        $pass_check = $this->getUser()->checkPassword($password);

        if ($pass_check instanceOf Exception) {
          // password verification encountered problem
          // TODO: move email alerter here
          $this->forward('default', 'error500');
          
        } elseif ( $pass_check ) {
          $this->getUser()->setAuthenticated(true);
          $this->getUser()->setAttribute('loginApp', 'admin');
          
          // redirect back to the same page
          $this->redirect($request->getUri());
          
        } else {
          $this->getUser()->setUsername(null);
          $this->errors[] = 'Invalid username or password';
        }
      }
    }
  }

  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->clear();
    $this->getUser()->setAuthenticated(false);
    $this->redirect('@homepage');
  }
}
