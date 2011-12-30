<?php

class SubjectWidgetFormChoice extends sfWidgetFormDoctrineChoice
{
  protected function configure( $options = array(), $attributes = array() )
  {
    parent::configure( $options, $attributes );

    $this->setOption('add_empty', true);   
    $this->setOption('model', 'Subject');   
    $this->setOption('key_method', 'getSlug');
    
    // FIXME what if not available to current libraries?
    $q = Doctrine_Core::getTable('Subject')->createQuery('s')
      ->leftJoin('s.Databases d')
      ->where('d.is_hidden = false')
      ->orderBy('s.name')
      ;
    //$c->add( DbSubjectPeer::LABEL, 'HOME', Criteria::NOT_EQUAL );
    
    $this->setOption('query', $q);
  }
}

