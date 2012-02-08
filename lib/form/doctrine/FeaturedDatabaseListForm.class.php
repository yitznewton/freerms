<?php

class FeaturedDatabaseListForm extends sfFormSymfony
{
  public function setup()
  {
    $databases = Doctrine_Core::getTable('Database')
      ->createQuery('d')
      ->where('d.is_featured = true')
      ->orderBy('LOWER(d.sort_title)')
      ->execute();

    $subform = new sfForm();

    foreach ($databases as $database) {
      $subform->embedForm($database->getId(),
        new FeaturedDatabaseForm($database));
      
      $subform->getWidgetSchema()->setLabel(false);
    }

    $this->embedForm('Database', $subform);

    parent::setup();
  }
}

