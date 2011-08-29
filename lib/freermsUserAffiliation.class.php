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
   * @var freermsUserInterface
   */
  protected $user;
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
   * @param freermsUserInterface $user 
   * @param sfContext $context
   */
  public function __construct( freermsUserInterface $user, sfContext $context )
  {
    $this->user    = $user;
    $this->context = $context;
  }
  
  /**
   * @return array int[]
   */
  public function get()
  {
    if ( isset( $this->libraryIds )) {
      return $this->libraryIds;
    }
    
    $this->library_ids = array();
    
    if ( $onsite_library_id = $this->getOnsiteLibraryId() ) {
      $this->library_ids[] = $onsite_library_id;
    }
    
    $this->libraryIds = array_merge(
      $this->library_ids, $this->user->getLibraryIds() );
    
    return $this->libraryIds;
  }
  
  /**
   * Returns an arbitrary single affiliated Library id, if applicable
   *
   * @return int
   */
  public function getOne()
  {
    if ( $ids = $this->get() ) {
      return $ids[0];
    }
    else {
      return null;
    }
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
    if ( isset( $this->isForceLogin )) {
      return $this->isForceLogin;
    }
    
    // needs to be namespaced for sfGuardPlugin to cleanup on logout
    if ( $this->user->getAttribute('force-login', null, 'sfGuardSecurityUser')) {
      return $this->isForceLogin = true;
    }
    
    $value = $this->context->getRequest()->hasParameter('force-login');
    
    $this->user->setAttribute( 'force-login', $value, 'sfGuardSecurityUser' );
    
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
    if ( isset( $this->onsiteLibraryId )) {
      return $this->onsiteLibraryId;
    }
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $offsite_ips = sfConfig::get('app_offsite-testing-ip-addresses');
    
    if ( ! is_array( $offsite_ips )) {
      $offsite_ips = array( $offsite_ips );
    }
    
    if ( in_array( $ip, $offsite_ips )) {
      return $this->onsiteLibraryId = false;
    }
    elseif (
      $onsite_library = LibraryPeer::retrieveByIp( $ip )
    ) {
      return $this->onsiteLibraryId = $onsite_library->getId();
    }
    else {
      return $this->onsiteLibraryId = false;
    }
  }
}
