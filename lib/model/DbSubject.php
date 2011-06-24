<?php

class DbSubject extends BaseDbSubject
{
  public function __toString()
  {
    return $this->getLabel();
  }  

  public function getEResourceDbSubjectAssocs($criteria = null, PropelPDO $con = null)
  {
    if ( ! $criteria ) {
      $criteria = new Criteria();
    }
    
    $criteria->addJoin( EResourceDbSubjectAssocPeer::ER_ID, EResourcePeer::ID );
    $criteria->add( EResourcePeer::DELETED_AT, null, Criteria::ISNULL );
    
    return parent::getEResourceDbSubjectAssocs( $criteria, $con );
  }
  
  /**
   * @return bool
   */
  public function isHomeSubject()
  {
    return $this->getLabel() == 'HOME';
  }
  
  /**
   * @param PropelPDO $con 
   */
  public function delete(PropelPDO $con = null) {
    if ( $this->isHomeSubject() ) {
      throw new RuntimeException('Cannot delete home subject');
    }
    
    parent::delete($con);
  }
}
