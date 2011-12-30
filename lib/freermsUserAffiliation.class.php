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
   * @var sfContext
   */
  protected $context;
  /**
   * @var array int[]
   */
  protected $libraryIds;
  /**
   * @var bool
   */
  protected $isForceLogin;
  /**
   * @var int
   */
  protected $onsiteLibraryId;
  
  /**
   * @param sfContext $context
   */
  public function __construct(sfContext $context)
  {
    if (!($context->getUser() instanceof freermsSecurityUser)) {
      $msg = 'user class must implement freermsSecurityUser';
      throw new RuntimeException($msg);
    }
    
    $this->context = $context;
  }
  
  /**
   * @return array int[]
   */
  public function getLibraryIds()
  {
    if (isset($this->libraryIds)) {
      return $this->libraryIds;
    }
    
    $this->libraryIds = $this->context->getUser()->getLibraryIds();
    
    if ($this->getOnsiteLibraryId()) {
      array_unshift($this->libraryIds, $this->getOnsiteLibraryId());
    }

    return $this->libraryIds;
  }
  
  /**
   * @return bool
   */
  public function isOnsite()
  {
    return (bool) $this->getOnsiteLibraryId();
  }
  
  /**
   * @return bool
   */
  public function isForceLogin()
  {
    if (isset($this->isForceLogin)) {
      return $this->isForceLogin;
    }
    
    // needs to be namespaced for sfGuardPlugin to cleanup on logout
    if (
      $this->context->getUser()
        ->getAttribute('force-login', null, 'sfGuardSecurityUser')
    ) {
      return $this->isForceLogin = true;
    }
    
    $value = $this->context->getRequest()->hasParameter('login');
    
    $this->context->getUser()->setAttribute('force-login',
      $value, 'sfGuardSecurityUser');
    
    return $value;
  }
  
  /**
   * Returns the id of the onsite Library, if any, as matched by client IP
   * address
   *
   * @return int|bool
   */
  protected function getOnsiteLibraryId()
  {
    if (isset($this->onsiteLibraryId)) {
      return $this->onsiteLibraryId;
    }
    
    $onsiteLibrary = Doctrine_Core::getTable('Library')
      ->findOneByIpAddress($this->context->getRequest()->getRemoteAddress());

    if ($onsiteLibrary) {
      return $this->onsiteLibraryId = $onsiteLibrary->getId();
    }

    return $this->onsiteLibraryId = false;
  }
}

