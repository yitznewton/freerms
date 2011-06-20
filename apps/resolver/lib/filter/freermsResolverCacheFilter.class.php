<?php

class freermsResolverCacheFilter extends sfFilter
{
  public function execute( $filterChain )
  {
    $affiliation = $this->getContext()->getAffiliation();
    
    if ( $this->getContext()->getAffiliation()->get() ) {
      $this->addCache();
    }
 
    $filterChain->execute();
  }
  
  protected function addCache()
  {
    // TODO: get this to read lifetime from config instead of hardcoded
    
    $this->getContext()->getViewCacheManager()
      ->addCache( 'database', 'index', array('lifeTime' => 300) );
  }
}
