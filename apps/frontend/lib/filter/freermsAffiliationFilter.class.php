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
  public function execute( $filterChain )
  {
    if ($this->isFirstCall()) {
      $this->doExecute();
    }
    
    $filterChain->execute();
  }
  
  protected function doExecute()
  {
    $affiliation = new freermsUserAffiliation($this->getContext());
    
    $this->getContext()->setAffiliation($affiliation);

    $user = $this->getContext()->getUser();
    
    if (
      $this->getContext()->getRequest()->isForceLogin()
      && !$user->isAuthenticated()
    ) {
      $this->forwardToLoginAction();
    }
    
    if (!$affiliation->isOnsite() && !$user->isAuthenticated()) {
      $this->forwardToLoginAction();
    }
    
    // TODO: whatif isAuthenticated but has no affiliation?
  }
  
  protected function forwardToLoginAction()
  {
    $this->getContext()->getController()->forward(
      sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    
    throw new sfStopException();
  }
}

