<?php
require_once __DIR__.'/baseAccessAction.class.php';

class unrestrictedAccessAction extends baseAccessAction
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const DESCRIPTION       = 'Unrestricted';
  
  public function execute($request)
  {
    $this->logUsageAndRedirect($this->getUser()->getFlash('database_url'));
  }
}

