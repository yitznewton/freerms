<?php

class ipComponents extends sfComponents
{
  public function executeUnregistered()
  {
    $this->ip_reg_events = IpRegEventPeer::doSelect( new Criteria() );
  }
}
