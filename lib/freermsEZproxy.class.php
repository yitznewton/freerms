<?php

class freermsEZproxy
{
  static public function getEZproxyTicketUrl(Library $library, $access_url, $user = 'user', $encoding = 'md5' )
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
