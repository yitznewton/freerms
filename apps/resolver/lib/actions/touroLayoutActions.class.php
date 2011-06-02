<?php

class touroLayoutActions extends sfActions
{
  public function preExecute()
  {
    $cookie_domain = $_SERVER['SERVER_NAME'];
    
    if ( strpos('.', $cookie_domain) !== false ) {
      $last_dot_pos = 0 - strlen($cookie_domain)
                      + strrpos( $cookie_domain, '.' ) - 1;
      $cookie_domain = substr(
        $cookie_domain,
        strrpos( $cookie_domain, '.', $last_dot_pos )
      );
    }

    // check for layout in GET and cookie
    if ( $this->getRequest()->hasParameter('site') ) {
      $layout = strtolower( $this->getRequest()->getParameter('site') );
    }
    elseif ( $this->getRequest()->getCookie('layout') ) {
      $layout = strtolower( $this->getRequest()->getCookie('layout') );
    }
    else {
      $layout = 'tc';
    }

    if ( $layout != 'tc' && $layout != 'nevada' ) {
      $layout = 'tc';
    }

    $this->getUser()->setAttribute( 'layout', $layout );
    $this->setLayout( $layout );
    $this->getResponse()->setCookie(
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
    $this->getUser()->setAttribute('layout', 'tc');
    $this->setLayout( 'tc' );
    $this->getResponse()->addStylesheet('/tc/drupal.css', '', array('media' => 'all'));
    $this->getResponse()->addStylesheet('/tc/drupal-p.css', '', array('media' => 'print'));
    $this->getResponse()->addJavascript('/tc/drupal.js');
  }

  protected function layoutNevada()
  {
    $this->getUser()->setAttribute('layout', 'nevada');
    $this->setLayout( 'nevada' );
    $this->getResponse()->addJavascript('jquery.js');
    $this->getResponse()->addStylesheet('/nevada/nevada_native.css');
    $this->getResponse()->addJavascript('/nevada/nevada_native.js');
  }
}
