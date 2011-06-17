<?php

class freermsResolverCacheManager extends sfViewCacheManager
{
  public function generateCacheKey($internalUri, $hostName = '', $vary = '', $contextualPrefix = '')
  {
    $key = parent::generateCacheKey($internalUri, $hostName, $vary,
      $contextualPrefix);
    
    $affiliation_array = $this->getContext()->get('affiliation')->get();
    
    sort( $affiliation_array );
    
    $affiliation_string = implode( '-', $affiliation_array );
    
    return $key . '-' . $affiliation_string;
  }
}
