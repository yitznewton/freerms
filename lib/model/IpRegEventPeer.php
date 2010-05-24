<?php

require 'lib/model/om/BaseIpRegEventPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'ip_reg_events' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Thu May 13 10:33:23 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class IpRegEventPeer extends BaseIpRegEventPeer {
  public static function retrieveAll()
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn( IpRegEventPeer::OLD_START_IP );
    $c->addAscendingOrderByColumn( IpRegEventPeer::NEW_START_IP );

    return IpRegEventPeer::doSelect( $c );
  }
} // IpRegEventPeer
