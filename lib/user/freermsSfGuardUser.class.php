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
class freermsSfGuardUser extends sfGuardSecurityUser implements freermsSecurityUser
{
  /**
   * @var array int[]
   */
  protected $libraryIds;

  public function initialize(sfEventDispatcher $dispatcher,
    sfStorage $storage, $options = array())
  {
    parent::initialize($dispatcher, $storage, $options);

    $this->credentials = $this->getGroupNames();
  }

  public function getLibraryIds()
  {
    if (isset($this->libraryIds)) {
      return $this->libraryIds;
    }
    
    if (!$this->isAuthenticated()) {
      return $this->libraryIds = array();
    }

    $q = new Doctrine_RawSql();

    $q->select('l.id')
      ->from('library l, sf_guard_group g, sf_guard_user_group ug '
             . 'WHERE l.code = g.name '
             . 'AND g.id = ug.group_id '
             . 'AND ug.user_id = ?')
      ->addComponent('l', 'Library')
      ;

    $result = $q->execute(
      $this->getGuardUser()->getId(),
      Doctrine_Core::HYDRATE_NONE
      );

    // flatten array of array of ID into array of IDs
    return $this->libraryIds = array_map(function($v) {
      return $v[0];
    }, $result);
  }
}

