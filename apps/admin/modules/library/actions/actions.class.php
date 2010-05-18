<?php

require_once dirname(__FILE__).'/../lib/libraryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/libraryGeneratorHelper.class.php';

/**
 * library actions.
 *
 * @package    freerms
 * @subpackage library
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class libraryActions extends autoLibraryActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new LibraryForm();

    $this->ips = IpRangePeer::retrieveIpsByLibraryId(1);
    $this->eresources = null;
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($library = LibraryPeer::retrieveByPk($request->getParameter('id')), sprintf('Object library does not exist (%s).', $request->getParameter('id')));
    $this->form = new LibraryForm($library);

    $this->ips = IpRangePeer::retrieveIpsByLibraryId($request->getParameter('id'));
    $this->eresources = EResourcePeer::retrieveByLibraryId($request->getParameter('id'));
  }
}