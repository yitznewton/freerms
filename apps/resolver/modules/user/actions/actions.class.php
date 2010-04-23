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
  public function preExecute()
  {
    layoutActions::chooseLayout( $this );
  }

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
    
    if ($this->getUser()->getOnsiteLibraryId()) {
      $this->getUser()->setAuthenticated(true);
      $this->getUser()->setAttribute('userLibraryIds',
        array($this->getUser()->getOnsiteLibraryId()));
      $this->redirect($request->getUri());
    }
   
    $username = $request->getParameter('username');
    $password = $request->getParameter('password');

    $this->username = $username;
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
        $this->getUser()->setUsername( $username );
        $pass_check = $this->getUser()->checkPassword($password);
        
        if ($pass_check instanceOf Exception) {
          // password verification encountered problem
          $recipient = sfConfig::get('app_admin-email', 'www@localhost');
          $body = "Error:\n".$pass_check->getMessage();
          $subject = '[FreERMS ERROR] User API failure';
          
          if (sfConfig::get('app_send-alert-emails', false)) {
            freermsActions::sendNotifyEmail($recipient, $body, $subject);
          }
          $this->forward('default', 'error500');
          
        } elseif ( $pass_check ) {
          $this->getUser()->setAuthenticated(true);
          $this->getUser()->setAttribute('loginApp', 'resolver');
          
          // redirect back to the same page
          $this->redirect($request->getUri());
          
        } else {
          $this->getUser()->setAttribute('username', null);

          switch ($this->getUser()->getFlash('loginError')) {
            case 'Account expired':
              $this->errors[] = "We're sorry, your account appears "
                              . 'to have expired.';
              break;

            case 'Invalid username or password':
              $this->errors[] = "We're sorry, the username or password "
                              . 'you entered is invalid.';
              break;
            
            default:
              $this->errors[] = "We're sorry, there was a login error.";
          }
        }
      }
    }
  }

  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->clear();
    $this->getUser()->setAuthenticated(false);
    $this->forward('user', 'redirectHome');
  }
  
  public function executeLoginFailed(sfWebRequest $request)
  {
  }
  
  public function executeRedirectHome(sfWebRequest $request)
  {
    $this->redirect(sfConfig::get('app_homepage-redirect-url'));
  }
}
