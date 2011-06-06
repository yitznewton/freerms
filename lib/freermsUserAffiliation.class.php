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
   * @var array int[]
   */
  protected $libraryIds;
  /**
   * @var bool
   */
  protected $isOnsite;
  /**
   * @var int
   */
  protected $onsiteLibraryId;
  
  /**
   * @param freermsUserInterface $user 
   */
  public function __construct( freermsUserInterface $user )
  {
    $this->user = $user;
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
    if ( ! isset( $this->isOnsite ) ) {
      $this->getOnsiteLibraryId();
    }
    
    return $this->isOnsite;
  }
  
  /**
   * Returns the id of the onsite Library, if any, as matched by client IP
   * address
   *
   * @return int
   */
  protected function getOnsiteLibraryId()
  {
    if ( isset( $this->isOnsite )) {
      return $this->onsiteLibraryId;
    }
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $offsite_ips = sfConfig::get('app_offsite-testing-ip-addresses');
    
    if ( ! is_array( $offsite_ips )) {
      $offsite_ips = array( $offsite_ips );
    }
    
    if ( in_array( $ip, $offsite_ips )) {
      $this->isOnsite = false;
      return null;
    }
    elseif (
      $onsite_library = LibraryPeer::retrieveByIp( $ip )
    ) {
      $this->isOnsite = true;
      return $this->onsiteLibraryId = $onsite_library->getId();
    }
    else {
      $this->isOnsite = false;
      return null;
    }
  }
}
