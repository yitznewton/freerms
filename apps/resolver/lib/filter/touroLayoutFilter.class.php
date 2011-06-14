<?php
/**
 * FreERMS
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to yitznewton@hotmail.com so we can send you a copy immediately.
 *
 * @package filter
 */
/**
 * touroLayoutFilter detects site and applies template based on that
 *
 * @package filter
 * @copyright  Copyright (c) 2011 Benjamin Schaffer (http://yitznewton.org/)
 */
class touroLayoutFilter extends sfFilter
{
  protected $user;
  protected $request;
  protected $response;
  protected $action;
  
  public function execute( $filterChain )
  {
    if ( $this->isFirstCall() ) {
      $this->user     = $this->getContext()->getUser();
      $this->request  = $this->getContext()->getRequest();
      $this->response = $this->getContext()->getResponse();
      $this->action   = $this->getContext()->getActionStack()
        ->getLastEntry()->getActionInstance();
      
      $this->doExecute();
    }
    
    $filterChain->execute();
  }
  
  protected function doExecute()
  {
    $cookie_domain = $_SERVER['SERVER_NAME'];
    
    if ( strpos($cookie_domain, '.') !== false ) {
      $cookie_domain = preg_replace('/^[^\.]+/', '', $cookie_domain);
    }

    // check for layout in GET and cookie
    if ( $this->request->hasParameter('site') ) {
      $layout = strtolower( $this->request->getParameter('site') );
    }
    elseif ( $this->request->getCookie('layout') ) {
      $layout = strtolower( $this->request->getCookie('layout') );
    }
    else {
      $layout = 'tc';
    }

    if ( $layout != 'tc' && $layout != 'nevada' ) {
      $layout = 'tc';
    }

    $this->user->setAttribute( 'layout', $layout );
    $this->action->setLayout( $layout );
    $this->response->setCookie(
      'layout', $layout, '2030-12-31', '/', $cookie_domain
    );

    switch ( $layout ) {
      case 'tc':
        $this->layoutTC();
        return;

      case 'nevada':
        $this->layoutNevada();
        return;
    }
  }
  
  protected function layoutTC()
  {
    $this->user->setAttribute('layout', 'tc');
    $this->action->setLayout( 'tc' );
    $this->response->addStylesheet('/tc/drupal.css', '', array('media' => 'all'));
    $this->response->addStylesheet('/tc/drupal-p.css', '', array('media' => 'print'));
    $this->response->addJavascript('/tc/drupal.js');
  }

  protected function layoutNevada()
  {
    $this->user->setAttribute('layout', 'nevada');
    $this->action->setLayout( 'nevada' );
    $this->response->addJavascript('jquery.js');
    $this->response->addStylesheet('/nevada/nevada_native.css');
    $this->response->addJavascript('/nevada/nevada_native.js');
    $this->response->addStylesheet('nevada.css');
  }
}
