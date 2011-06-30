<?php

class AccessInfo extends BaseAccessInfo
{
  public function __toString()
  {
    return $this->getOnsiteAccessUri();
  }

	public function delete(PropelPDO $con = null)
  {
    $this->setDeletedAt( time() );
    $this->save( $con );
  }
  
  /**
   * Returns the name of the custom AccessHandler class corresponding to the
   * current AccessInfo 
   *
   * @return type string
   */
  public function getAccessHandlerClass()
  {
    if ( $this->isNew() ) {
      return null;
    }
    
    return 'AccessInfo' . $this->getId() . 'AccessHandler';
  }
}
