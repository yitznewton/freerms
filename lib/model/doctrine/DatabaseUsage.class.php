<?php

/**
 * DatabaseUsage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    freerms
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class DatabaseUsage extends BaseDatabaseUsage
{
  /**
   * @return array
   */
  public function getAdditionalData()
  {
    return json_decode($this->_get('additional_data'), true);
  }

  /**
   * @param array $v
   */
  public function setAdditionalData(array $v)
  {
    $this->_set('additional_data', json_encode($v));
  }

  /**
   * Convenience method bypassing the need to check for already-existing
   * records sharing the specified database_id and sessionid
   */
  public function log()
  {
    try {
      $this->save();
    }
    catch (Doctrine_Connection_Exception $e) {
      if (stripos($e->getMessage(), 'constraint') === false) {
        // unexpected Exception
        throw $e;
      }

      // ignore existing record; the conditional works for
      // SQLite, MySQL, PostgreSQL
    }
  }
}

