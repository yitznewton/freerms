<?php

class EZproxyAccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  const DESCRIPTION   = 'EZproxy';
  
  public function execute()
  {
    $proxy_uri = EZproxyAccessHandler::composeTicketUrl(
      $this->action->getUser()->getFirstLibrary(),
      $this->getAccessUri(),
      $this->action->getUser()->getAttribute('username')
    );

    $this->action->redirect($proxy_uri);

    return;
  }

  static public function composeTicketUrl(Library $library, $access_url, $user = 'user', $encoding = 'md5' )
  {
    if (!$user) {
      // blank or false
      $user = 'user';
    }

    if ($encoding != 'md5' && $encoding != 'sha1') {
      throw new Exception('Invalid encoding');
    }

    if ( ! is_string($access_url) ) {
      throw new Exception('Access URL must be a string');
    }

    //$key = $library->getEzproxyKey();
    //$key = 'tH3m4D$eeKrEtk3Y';  // test key
    preg_match('/\d+/', $library->getEzproxyHost(), $match);
    if (isset($match)) {
      $key = 'tourosecret' . $match[0];
    }
    $proxyDate = '$c' . date('YmdHis');
    $proxyBlob = $encoding($key . $user . $proxyDate);

    $proxyUrl = 'http://' . $library->getEzproxyHost() . '/login?user=';
    $proxyUrl .= $user . '&ticket=';
    $proxyUrl .= urlencode($proxyBlob) . urlencode($proxyDate);
    $proxyUrl .= '&url=' . $access_url;

    return $proxyUrl;
  }
}
