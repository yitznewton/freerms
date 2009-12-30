<?php

class AuthMethodPeer extends BaseAuthMethodPeer
{
  public static function retrieveByLabel($label)
  {
    $c = new Criteria();
    $c->add(AuthMethodPeer::LABEL, $label);
    
    return AuthMethodPeer::doSelectOne($c);
  }
  
  public static function retrieveOnsiteAuth()
  {
    $c = new criteria();
    $c->add(AuthMethodPeer::IS_VALID_ONSITE, 1);
    
    return AuthMethodPeer::doSelect($c);
  }
  
  public static function retrieveOffsiteAuth()
  {
    $c = new criteria();
    $c->add(AuthMethodPeer::IS_VALID_OFFSITE, 1);
    
    return AuthMethodPeer::doSelect($c);
  }
}
