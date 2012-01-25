<?php

class UserDataService
{
  /**
   * @var freermsSecurityUser
   */
  protected $user;

  /**
   * @param freermsSecurityUser $user
   */
  protected function __construct(freermsSecurityUser $user)
  {
    $this->user = $user;
  }

  /**
   * @param Doctrine_RawSql $query For dependency injection
   * @return array
   */
  public function get(Doctrine_RawSql $query = null)
  {
    if (!$this->user->isAuthenticated()) {
      return array();
    }

    if (!$query) {
      $query = new Doctrine_RawSql();
    }

    $data = array();
    
    // avoid method chaining to simplify stubbing
    $query->select('g.id');
    $query->from('sf_guard_group g, sf_guard_user_group ug '
                 . 'WHERE g.id = ug.group_id '
                 . 'AND ug.user_id = ? '
                 . 'AND NOT EXISTS (SELECT * FROM library l '
                 . 'WHERE l.code = g.name)');
    $query->addComponent('g', 'sfGuardGroup');

    $result = $query->execute(
      $this->user->getGuardUser()->getId(),
      Doctrine_Core::HYDRATE_NONE
      );

    // flatten array of array of ID into array of IDs
    $ids = array_map(function($v) {
      return $v[0];
    }, $result);

    return array('groups' => $ids);
  }

  /**
   * @param freermsSecurityUser $user
   * @return UserDataService
   */
  public static function factory(freermsSecurityUser $user)
  {
    if ($user instanceof freermsSfGuardUser) {
      return new UserDataService($user);
    }
    // to extend, add conditions:
    // else if ($user instanceof someClass) {
    //   return new UserDataServiceSubclass($user);
    // }
    else {
      throw new RuntimeException(
        'Unrecognized subclass of freermsSecurityUser');
    }
  }
}

