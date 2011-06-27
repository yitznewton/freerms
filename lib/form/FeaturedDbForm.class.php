<?php

class FeaturedDbForm extends sfFormSymfony
{
  public function setup()
  {
    $c = new Criteria();
    $c->add( EResourcePeer::IS_FEATURED, true );
    
    $featured_ers = EResourcePeer::doSelect( $c );
    
    $subform = new sfForm();
    
    foreach ( $featured_ers as $er ) {
      $subform->embedForm( $er->getId(), new EResourceFeaturedForm( $er ) );
      $subform->getWidgetSchema()->setLabel( false );
    }
    
    $this->embedForm( 'EResources', $subform );
    
    
    parent::setup();
  }
}
