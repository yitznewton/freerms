<?php

/**
 * sfGuardGroupTable
 * 
 */
class sfGuardGroupTable extends PluginsfGuardGroupTable
{
  /**
   * Inserts/updates an sfGuardGroup for the specified library
   *
   * @param Library $library
   */
  public function syncLibrary(Library $library)
  {
    $group = $this->findOneByName($library->getCode());
    
    if (!$group) {
      $group = new sfGuardGroup();
      $group->setName($library->getCode());
    }

    $group->setDescription($library->getName());
    $group->save();
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('sfGuardGroup');
  }
}

