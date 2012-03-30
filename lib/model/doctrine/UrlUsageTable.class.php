<?php

/**
 * UrlUsageTable
 * 
 */
class UrlUsageTable extends Doctrine_Table
{
  /**
   * @return array string[]
   */
  public function getAllHosts()
  {
    $q = 'SELECT DISTINCT host FROM url_usage ORDER BY host';

    $st = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh()
      ->query($q);

    return $st->fetchAll(PDO::FETCH_COLUMN, 0);
  }

  /**
   * Returns an instance of this class.
   *
   * @return object UrlUsageTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('UrlUsage');
  }
}
