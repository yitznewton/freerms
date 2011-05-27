<?php

class freermsSfGuardUser extends sfGuardSecurityUser implements freermsUserInterface
{
  public function getLibraryIds()
  {
    //return $this->getGroups();
  }
  
  public function getCredentials()
  {
    //return $this->getPermissions();
  }
}
