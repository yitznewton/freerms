<?php

/**
 * IpRangeTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class IpRangeTable extends Doctrine_Table
{
  /**
   * Find IpRanges that intersect with the given IpRange
   *
   * Available options:
   *  * include_inactive: include IpRanges marked as inactive
   *    (default false)
   *
   * @param IpRange $ipRange
   * @param array $options
   * @return Doctrine_Collection
   */
  public function findIntersecting(IpRange $ipRange, $options = array())
  {
    // algorithm explained at
    // http://stackoverflow.com/questions/143552/comparing-date-ranges
    $q = IpRangeTable::getInstance()->createQuery('i')
      ->where('i.start_ip_sort <= ?', $ipRange->getEndIpSort())
      ->andWhere('i.end_ip_sort >= ?', $ipRange->getStartIpSort())
      ;

    if (
      !isset($options['include_inactive'])
      || $options['include_inactive'] !== true
    ) {
      $q->andWhere('i.is_active = true');
    }

    return $q->execute();
  }

  /**
  * Returns an instance of this class.
  *
  * @return object IpRangeTable
  */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('IpRange');
  }
}

