<?php

/**
 * If user logged in within a different app, log out and force new login
 */
class loginAppFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $user = $this->getContext()->getUser();

    if (
      $user->getAttribute('loginApp') != $this->getParameter('app')
    ) {
      $user->getAttributeHolder()->clear();
      $user->setAuthenticated(false);
    }

    $filterChain->execute();
  }
}
