<?php
/*
 * for Exam Master
 */
class AccessInfo299AccessHandler extends RefererAccessHandler
{
  const IS_VALID_ONSITE  = true;
  const IS_VALID_OFFSITE = true;
  
  public function getAccessUri()
  {
    $library_ids   = $this->action->affiliation->get();
    
    $library_codes = LibraryPeer::getCodesForIds( $library_ids );
    
    if ( ! $library_codes ) {
      throw new RuntimeException('unauthorized');
    }
    
    $target = $this->getTarget( $library_codes );
    
    if ( ! $target ) {
      throw new RuntimeException('unauthorized');
    }

    return 'http://www.exammaster2.com/wdsentry/' . $target;
  }
  
  /**
   *
   * @param array string[] $libraries 
   * @return string
   */
  protected function getTarget( array $libraries )
  {
    foreach ( $libraries as $code ) {
      var_dump($code);
      switch ( $code ) {
        case 'TUN':
        case 'TUN-ALUM':
          return 'touro.htm';
        case 'THMED':
          return 'touro-lib.htm';
        default:
      }
    }

    return null;
  }
}
