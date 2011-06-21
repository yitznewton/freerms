<?php
/*
 * for Computer Database (links to multiple accounts)
 */
class AccessInfo266AccessHandler extends RefererAccessHandler
{
  const IS_VALID_ONSITE   = true;
  const IS_VALID_OFFSITE  = true;
  const FORCE_AUTH_ONSITE = false;
  
  protected function getAccessUri()
  {
    $affiliated_libraries = LibraryPeer::retrieveByPks(
      $this->affiliation->get() );
    
    $lib_code = $this->getGaleCode( $affiliated_libraries );
    
    if ( ! $lib_code ) {
      throw new freermsUnauthorizedException();
    }
    
    return "http://infotrac.galegroup.com/itweb/$lib_code?db=CDB";
  }
  
  /**
   * Cycle through Librarys until we find one that matches a Gale
   * subscription
   * 
   * @param array Library[] $libraries
   * @return string
   */
  protected function getGaleCode( array $libraries )
  {
    foreach ( $libraries as $library ) {
      switch ( $library->getCode() ) {
        case 'TCNY':
        case 'THMED':
        case 'LAW':
          return 'nysl_me_touro';
          
        case 'TUI':
          return 'tc_tui';
          
        case 'MOSCOW':
          return 'tc_moscow';
      }
    }
  }
}
