<?php
require_once __DIR__.'/baseAccessAction.class.php';

class ezproxyAccessAction extends baseAccessAction
{
  const IS_VALID_ONSITE   = false;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'EZProxy';

  /**
   * @param sfWebRequest $request
   */
  public function execute($request)
  {
    if (!$this->isSubscribed()) {
      throw new accessUnauthorizedException();
    }

    $library_ids = $this->getUserLibraryIds();

    $library = Doctrine_Core::getTable('Library')
      ->find($library_ids[0]);

    $this->redirectToEZproxy($this->getUser()
      ->getFlash('database_url'), $library);
  }

  protected function redirectToEZproxy($url, Library $library)
  {
    $username  = $this->getUser()->getUsername();
    $key       = $library->getEzproxyKey();
    $algorithm = $library->getEzproxyAlgorithm();

    $proxyDate = '$c' . date('YmdHis');
    $proxyBlob = $algorithm( $key . $user . $proxyDate );

    $proxyUrl = 'http://' . $library->getEzproxyHost() . '/login?user='
                . $username . '&ticket='
                . urlencode($proxyBlob) . urlencode($proxyDate)
                . '&url=' . $url;

    $this->redirect($proxyUrl);
  }
}

