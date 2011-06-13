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
    
    $credentials = $this->getFormCredentials( $library_codes );

    if ( ! $credentials ) {
      throw new RuntimeException('unauthorized');
    }
    
    $this->action->credentials = $credentials;
    $this->action->setLayout( false );
    $this->action->setTemplate( 'AccessInfo507' );
  }
  
  /**
   * @param array string[] $libraries 
   * @return array string[]
   */
  protected function getFormCredentials( array $libraries )
  {
    foreach ( $libraries as $code ) {
      switch ( $code ) {
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
