<?php
/*
 * for Small Business School
 */
class AccessInfo507AccessHandler extends BaseAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  
  public function execute()
  {
    $library_ids   = $this->action->affiliation->get();
    
    $library_codes = LibraryPeer::getCodesForIds( $library_ids );
    
    $affiliated_libraries = LibraryPeer::retrieveByPks(
      $this->action->affiliation->get());
    
    $credentials = $this->getFormCredentials( $affiliated_libraries );

    if ( ! $credentials ) {
      throw new RuntimeException('unauthorized');
    }
    
    $this->action->credentials = $credentials;
    $this->action->setLayout( false );
    $this->action->setTemplate( 'AccessInfo507' );
  }
  
  /**
   * @param array $libraries 
   * @return array string[]
   */
  protected function getFormCredentials( array $libraries )
  {
    foreach ( $libraries as $library ) {
      switch ( $library->getCode() ) {
        case 'TCNY':
          return array( 'user' => 'NY@touro.edu', 'pass' => 'NY');
        case 'TCS':
          return array( 'user' => 'Miami@touro.edu', 'pass' => 'Miami');
        default:
      }
    }
    
    return null;
  }
}
