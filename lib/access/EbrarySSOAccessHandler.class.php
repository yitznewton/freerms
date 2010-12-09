<?php

class EbrarySSOAccessHandler extends EZproxyAccessHandler
{
  public function execute()
  {
    // FIXME: take the Touro out of this... modularize the ebrary handler,
    // and add this as a config setting
    $ebrary_uri = 'http://' . $library->getEZProxyHost()
                  . '/ebrary/touro/unauthorized';

    $proxy_uri = EZproxyAccessHandler::composeTicketUrl(
      $this->action->getUser()->getFirstLibrary(),
      $ebrary_uri,
      $this->action->getUser()->getUsername()
    );

    $this->action->redirect( $proxy_uri );

    return;
  }
}
