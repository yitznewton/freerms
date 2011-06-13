<?php

class databaseComponents extends sfComponents
{
  public function executeLogoutLink()
  {
    if ( ! $this->getUser()->isAuthenticated() ) {
      return sfView::NONE;
    }
  }
}
