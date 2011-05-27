<?php

require 'lib/model/om/BaseContactPhone.php';


/**
 * Skeleton subclass for representing a row from the 'contact_phones' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Jun  4 11:56:57 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ContactPhone extends BaseContactPhone implements freermsSimpleAssoc {
  public function __toString()
  {
    return $this->getNumber();
  }

  public function getDataFieldName()
  {
    return 'number';
  }
} // ContactPhone