<?php

require 'lib/model/om/BaseOrganization.php';


/**
 * Skeleton subclass for representing a row from the 'organizations' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Apr 23 11:34:24 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Organization extends BaseOrganization {
  public function __toString()
  {
    return $this->getName();
  }
} // Organization
