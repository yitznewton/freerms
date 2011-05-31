<?php
/**
 * FreERMS
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to yitznewton@hotmail.com so we can send you a copy immediately.
 *
 * @version x
 * @package user
 */
/**
 * freermsSfGuardUser is an Adapter for the sfGuardPlugin user class 
 *
 * @package user
 * @copyright  Copyright (c) 2011 Benjamin Schaffer (http://yitznewton.org/)
 */
class freermsSfGuardUser extends sfGuardSecurityUser implements freermsUserInterface
{
  public function getLibraryIds()
  {
    $library_ids = array();
    
    foreach ( $this->getGroups() as $group ) {
      $library_ids[] = $group->getId();
    }
    
    return $library_ids;
  }
}