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
 * @package filter
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
    $affiliation = new freermsUserAffiliation( $this->user );
    
    if ( ! $affiliation->isOnsite() && ! $this->user->isAuthenticated() ) {
      $this->forwardToLoginAction();
    }
    
    // TODO: whatif isAuthenticated but has no affiliation?
    
    // push affiliation data to the action
    
    $this->getContext()->getActionStack()->getLastEntry()
      ->getActionInstance()->affiliation = $affiliation;
  }
  
  protected function forwardToLoginAction()
  {
    $this->getContext()->getController()->forward(
      sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    
    throw new sfStopException();
  }
}
