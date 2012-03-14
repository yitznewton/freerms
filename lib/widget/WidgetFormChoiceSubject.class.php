<?php

class WidgetFormChoiceSubject extends sfWidgetFormDoctrineChoice
{
  public function __construct($options = array(), $attributes = array())
  {
    $this->addOption('library_ids', array());

    parent::__construct($options, $attributes);
  }

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->setOption('add_empty', true);   
    $this->setOption('model', 'Subject');   
    $this->setOption('key_method', 'getSlug');
    
    $q = Doctrine_Core::getTable('Subject')->createQuery('s')
      ->select('s.id, s.name, s.slug')
      ->distinct()
      ->leftJoin('s.Databases d')
      ->where('d.is_hidden = false')
      ->orderBy('s.name')
      ;

    if (isset($options['library_ids']) && $options['library_ids']) {
      $q->leftJoin('d.Libraries l')
        ->andWhereIn('l.id', $options['library_ids'])
        ;
    }
    
    $this->setOption('query', $q);
  }
}

