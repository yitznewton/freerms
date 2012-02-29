<?php

class databaseComponents extends sfComponents
{
  public function executeFeaturedDatabases()
  {
    if ($this->subject) {
      $this->featuredDatabases = Doctrine_Core::getTable('Database')
        ->findFeaturedByLibraryIdsAndSubject($this->libraryIds, $this->subject);
    }
    else {
      $this->featuredDatabases = Doctrine_Core::getTable('Database')
        ->findGeneralFeaturedByLibraryIds($this->libraryIds);
    }
  }

  public function executeDatabases()
  {
    $this->databases = Doctrine_Core::getTable('Database')
      ->findByLibraryIdsAndSubject($this->libraryIds, $this->subject);
  }
}

