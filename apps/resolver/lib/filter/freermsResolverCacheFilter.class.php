<?php

class freermsResolverCacheFilter extends sfFilter
{
  public function execute( $filterChain )
  {
    if ( $this->getContext()->getAffiliation()->get() ) {
      $this->addCache();
    }
 
    $filterChain->execute();
  }
  
  protected function addCache()
  {
    // TODO: get this to read lifetime from config instead of hardcoded
    
    $cache_manager = $this->getContext()->getViewCacheManager();
    
    if ( $cache_manager instanceof freermsResolverCacheManager ) {
      $cache_manager->addCache(
        'database', 'index', array('lifeTime' => 300) );
    }
  }
}
