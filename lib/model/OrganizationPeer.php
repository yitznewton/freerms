<?php

require 'lib/model/om/BaseOrganizationPeer.php';

class OrganizationPeer extends BaseOrganizationPeer
{
  public static function retrieveKeyedArray()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(OrganizationPeer::NAME);
    $orgs = self::doSelect($c);

    $array = array();        
    foreach ($orgs as $l) {
      $array[$l->getId()] = $l->getName();
    }
   
    return $array;
  }
}
