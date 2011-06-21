<?php

class DbSubjectWidgetFormChoice extends sfWidgetFormPropelChoice
{
  protected function configure( $options = array(), $attributes = array() )
  {
    parent::configure( $options, $attributes );

    $this->setOption( 'add_empty', true );   
    $this->setOption( 'model', 'DbSubject' );   
    $this->setOption( 'key_method', 'getSlug' );
    
    $c = new Criteria();
    $c->addJoin( DbSubjectPeer::ID, EResourceDbSubjectAssocPeer::DB_SUBJECT_ID );
    $c->addJoin( EResourceDbSubjectAssocPeer::ER_ID, EResourcePeer::ID );
    $c->add( EResourcePeer::DELETED_AT, null, Criteria::ISNULL );
    $c->add( EResourcePeer::SUPPRESSION, 0 );
    $c->addAscendingOrderByColumn( DbSubjectPeer::LABEL );
    
    $this->setOption( 'criteria', $c );
  }
}
