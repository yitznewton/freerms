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
 * @version x
 */
/**
 * freermsUserAffiliation determines the user's Library affiliation
 *
 * @copyright  Copyright (c) 2011 Benjamin Schaffer (http://yitznewton.org/)
 */
class freermsUserAffiliation
{
  /**
   * @var freermsSecurityUser
   */
  protected $user;
  /**
   * @var sfWebRequest
   */
  protected $request;
  /**
   * @var sfNamespacedParameterHolder
   */
  protected $paramHolder;
  /**
   * @var array int[]
   */
  protected $libraryIds;
  /**
   * @var bool
   */
  protected $isOnsite;
  /**
   * @var int|false
   */
  protected $onsiteLibraryId;
  
  /**
   * @param freermsSecurityUser $user
   * @param sfWebRequest $request
   * @param sfNamespacedParameterHolder $paramHolder
   */
  public function __construct(freermsSecurityUser $user, sfWebRequest $request,
    sfNamespacedParameterHolder $paramHolder = null)
  {
    $this->user    = $user;
    $this->request = $request;

    $this->paramHolder = $paramHolder ? $paramHolder
      : $user->getAttributeHolder();
  }
  
  /**
   * @return array int[]
   */
  public function getLibraryIds()
  {
    if (isset($this->libraryIds)) {
      return $this->libraryIds;
    }

    if ($this->paramHolder->has('libraryIds')) {
      return $this->libraryIds = $this->paramHolder->get('libraryIds');
    }
    
    $this->libraryIds = $this->user->getLibraryIds();
    
    if ($this->getOnsiteLibraryId()) {
      array_unshift($this->libraryIds, $this->getOnsiteLibraryId());
    }

    if ($this->libraryIds) {
      $this->paramHolder->set('libraryIds', $this->libraryIds);
    }

    return $this->libraryIds;
  }
  
  /**
   * @return bool
   */
  public function isOnsite()
  {
    if (isset($this->isOnsite)) {
      return $this->isOnsite; 
    }

    if ($this->getOnsiteLibraryId()) {
      return $this->isOnsite = true;
    }
    else {
      return $this->isOnsite = false;
    }
  }
  
  /**
   * Returns the id of the onsite Library, if any, as matched by client IP
   * address
   *
   * @return int|false
   */
  protected function getOnsiteLibraryId()
  {
    if (isset($this->onsiteLibraryId)) {
      return $this->onsiteLibraryId;
    }

    if ($this->paramHolder->has('onsiteLibraryId')) {
      return $this->onsiteLibraryId
        = $this->paramHolder->get('onsiteLibraryId');
    }
    
    $onsiteLibrary = Doctrine_Core::getTable('Library')
      ->findOneByIpAddress(
        $this->request->getRemoteAddress());

    $this->onsiteLibraryId = $onsiteLibrary ? $onsiteLibrary->getId() : false;

    $this->paramHolder->set('onsiteLibraryId', $this->onsiteLibraryId);

    return $this->onsiteLibraryId;
  }
}

