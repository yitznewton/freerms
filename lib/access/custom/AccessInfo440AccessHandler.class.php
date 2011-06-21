<?php
/*
 * for UpToDate
 */
class AccessInfo440AccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;

  public function execute()
  {
    $library_ids   = $this->affiliation->get();
    $library_codes = LibraryPeer::getCodesForIds( $library_ids );
    
    if ( ! $library_codes ) {
      throw new RuntimeException('unauthorized');
    }

    $this->action->utd_codes = $this->getUTDCodes( $library_codes );
    $this->action->setTemplate('AccessInfo440');
  }
  
  /**
   * @param array string[] $library_codes 
   * @return array string[]
   */
  protected function getUTDCodes( array $library_codes )
  {
    foreach ( $library_codes as $code ) {
      switch ( $code ) {
        case 'TUN':
          $a = '65466';
          $b = '93527567';
          $portal = 'TouroNV166095';
          break;
        
        case 'THMED':
          $a = '41320';
          $b = '88196129';
          $portal = 'TouroCollOfOsteopathicMed67218382';
          break;
      }
    }
    
    if ( ! isset( $portal )) {
      throw new RuntimeException('unauthorized');
    }
    
    $key = gmdate('imdH', time());
    $key -= 10000;

    // BC math functions to work around very long integer problems
    $key = bcmul( strval($key), $a );
    $key = bcsub( $key, $b );
    
    return array( 'portal' => $portal, 'key' => $key );
  }
}
