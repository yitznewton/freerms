<?php

class freermsSecurityFilter extends sfBasicSecurityFilter
{
  public function execute($filterChain)
  {
    if (
      (sfConfig::get('sf_login_module') == $this->context->getModuleName())
        && (sfConfig::get('sf_login_action') == $this->context->getActionName())
      ||
      (sfConfig::get('sf_secure_module') == $this->context->getModuleName())
        && (sfConfig::get('sf_secure_action') == $this->context->getActionName())
      ||
      $this->context->getUser()->isAuthenticated()
    )
    {
      $filterChain->execute();

      return;
    }

    if ($this->context->getRequest()->hasParameter('force-login')) {
      $this->forwardToLoginAction();
    }

    if (!$this->context->getAffiliation()->getLibraryIds()) {
      $this->forwardToLoginAction();
    }

    $filterChain->execute();
  }
}

