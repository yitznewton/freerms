<?php

class layoutActions extends sfActions
{
  public static function chooseLayout( sfActions $calling )
  {
    $cookie_domain = $_SERVER['SERVER_NAME'];
    $last_dot_pos = 0 - strlen($cookie_domain)
                  + strrpos( $cookie_domain, '.' ) - 1;
    $cookie_domain = substr(
      $cookie_domain,
      strrpos( $cookie_domain, '.', $last_dot_pos )
    );

    if ($calling->getRequest()->hasParameter('site')) {
      $site = $calling->getRequest()->getParameter('site');

      // check if template exists
      if (file_exists(sfConfig::get('sf_app_template_dir')."/$site.php")) {
        $calling->getUser()->setAttribute('layout', $site);
        $calling->setLayout($site);

        $calling->getResponse()->setCookie(
          'layout', $site, '2030-12-31', '/', $cookie_domain
        );

        return true;
      }
    }

    if ($calling->getUser()->hasAttribute('layout')) {
      $calling->setLayout($calling->getUser()->getAttribute('layout'));
      $calling->getResponse()->setCookie(
        'layout',
        $calling->getUser()->getAttribute('layout'),
        '2030-12-31',
        '/',
        $cookie_domain
      );
      return true;
    }

    if (
      $calling->getRequest()->getCookie('layout')
      && file_exists(
        sfConfig::get('sf_app_template_dir') . '/'
        . $calling->getRequest()->getCookie('layout').'.php'
      )
    ) {
      $site = $calling->getRequest()->getCookie('layout');
      $calling->getUser()->setAttribute('layout', $site);
      $calling->setLayout($site);
      return true;
    }

    return false;
  }
}
