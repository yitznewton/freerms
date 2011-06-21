<?php
class AccessInfo1AccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  
  public function execute( sfAction $action )
  {
    // do some logic, and redirect user as appropriate
  }
}
