<?php

class LibraryPeer extends BaseLibraryPeer
{
  public static function retrieveKeyedArray()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(LibraryPeer::NAME);
    $libs = self::doSelect($c);
    
    $array = array();
    foreach ($libs as $l) {
      $array[$l->getId()] = $l->getName();
    }
    
    return $array;
  }
  
  public static function retrieveByCode($code)
  {
    $c = new Criteria();
    $c->add(LibraryPeer::CODE, $code);
    
    return self::doSelectOne($c);
  }
}
