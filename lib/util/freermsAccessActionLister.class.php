<?php

class freermsAccessActionLister
{
  const ONSITE  = 0;
  const OFFSITE = 1;

  /**
   * @var string The directory holding the access actions
   */
  protected $dir;
  /**
   * @var array string[] All access action classes in the system
   */
  protected $allActions = array();

  public function __construct($dir)
  {
    $this->dir = $dir;
  }

  /**
   * Returns associative array of available access actions
   *
   * @param int $site Retrieve actions for onsite or offsite
   *
   * @return array
   */
  public function retrieve($site)
  {
    if (!$this->allActions) {
      $this->allActions = $this->requireAndGetActions();
    }

    $ret = array();

    foreach ($this->allActions as $action) {
      $classname = $action . 'Action';

      switch($site) {
        case self::ONSITE:
          if ($classname::IS_VALID_ONSITE) {
            $ret[$action] = $classname::DESCRIPTION;
          }
          break;

        case self::OFFSITE:
          if ($classname::IS_VALID_OFFSITE) {
            $ret[$action] = $classname::DESCRIPTION;
          }
          break;

        default:
          throw new InvalidArgumentException(
            'Invalid site designation ' . $site);
      }
    }

    asort($ret);

    return $ret;
  }

  /**
   * @param string $dir
   */
  protected function requireAndGetActions()
  {
    $classes = array();

    $files = scandir($this->dir);

    foreach ($files as $file) {
      if (preg_match('/(.+Access)Action\.class\.php$/', $file, $matches)) {
        require_once $this->dir . '/' . $file;
        $classes[] = $matches[1];
      }
    }

    return $classes;
  }
}

