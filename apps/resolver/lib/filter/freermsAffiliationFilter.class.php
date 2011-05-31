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
 * @package user
 */
/**
 * freermsAffiliationFilter detects and takes actions based on user's
 * affilation
 *
 * @package filter
 * @copyright  Copyright (c) 2011 Benjamin Schaffer (http://yitznewton.org/)
 */
class freermsAffiliationFilter extends sfFilter
{
  protected $user;
  
  public function execute( $filterChain )
  {
    $this->user = $this->getContext()->getUser();
    
    if ( $this->isFirstCall() ) {
      $this->doExecute();
    }
    
    $filterChain->execute();
  }
  
  protected function doExecute()
  {
    $onsite_library_id = $this->getOnsiteLibraryId();
    
    if ( ! $onsite_library_id && ! $this->user->isAuthenticated() ) {
      $this->forwardToLoginAction();
    }
    
    // push affiliation data to the action
    
    $action = $this->getContext()->getActionStack()->getFirstEntry()
      ->getActionInstance();
    
    $action->user_affiliation = array();
    
    if ( $onsite_library_id ) {
      $action->user_affiliation[] = $onsite_library_id;
    }
    
    if ( $this->user->isAuthenticated() ) {
      $action->user_affiliation = array_merge(
        $action->user_affiliation, $this->user->getLibraryIds() );
    }
  }
  
  /**
   * @return string
   */
  protected function getOnsiteLibraryId()
  {
    if ( $this->user->getAttribute('is_onsite') ) {
      // already detected as onsite
      return $this->user->getAttribute('onsite_library_id');
    }
    elseif ( $this->user->getAttribute('is_onsite') === false ) {
      // already detected as offsite
      return null;
    }
    elseif (
      $_SERVER['REMOTE_ADDR'] == sfConfig::get('app_offsite-testing-ip')
    ) {
      $this->user->setAttribute( 'is_onsite', false );
      return null;
    }
    elseif (
      $onsite_library = LibraryPeer::retrieveByIp( $_SERVER['REMOTE_ADDR'] )
    ) {
      $onsite_library_id = $onsite_library->getId();

      $this->user->setAttribute( 'is_onsite', true );
      $this->user->setAttribute( 'onsite_library_id', $onsite_library_id );

      return $onsite_library_id;
    }
    else {
      $this->user->setAttribute( 'is_onsite', false );
      return null;
    }
  }
  
  protected function forwardToLoginAction()
  {
    $this->getContext()->getController()->forward(
      sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    
    throw new sfStopException();
  }
}
