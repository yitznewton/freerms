<?php

/**
 * LibraryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LibraryTable extends Doctrine_Table
{
  /**
   * @param string $v
   * @return Library
   */
  public function findOneByIpAddress($v)
  {
    $testIp = new IpRange();
    $testIp->setStartIp($v);

    if (Doctrine_Core::getTable('IpRange')->findIntersecting(
      $testIp, array('is_active' => true, 'is_excluded' => true))->count()
    ) {
      return null;
    }
    
    $foundIps = Doctrine_Core::getTable('IpRange')->findIntersecting(
      $testIp, array('is_active' => true, 'is_excluded' => false));

    if ($foundIps->count() && $foundIps[0]->getLibrary()) {
      return $foundIps[0]->getLibrary();
    }
    else {
      return null;
    }
  }

  /**
   * Returns an instance of this class.
   *
   * @return object LibraryTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Library');
  }
}
