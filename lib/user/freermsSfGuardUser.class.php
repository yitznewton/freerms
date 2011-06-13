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
    if ( ! $this->isAuthenticated() ) {
      return array();
    }
    
    $con = Propel::getConnection();
    
    $q = 'SELECT l.id FROM libraries l '
         . 'JOIN sf_guard_group g ON l.code = g.name '
         . 'JOIN sf_guard_user_group ug ON g.id = ug.group_id '
         . 'WHERE ug.user_id = ?';
    
    $st = $con->prepare( $q );
    $st->execute( array( $this->getGuardUser()->getId() ));

    return $st->fetchAll( PDO::FETCH_COLUMN );
  }
}
