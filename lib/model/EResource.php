<?php

class EResource extends BaseEResource
{
  public function getUserURL()
  {
    // needed for api app
    sfProjectConfiguration::getActive()->loadHelpers( array( 'Url' ) );
    
    return public_path( '/database/' . $this->getId(), true );
  }

  public function delete(PropelPDO $con = null)
  {
    $cur_time = time();
    
    $access      = $this->getAccessInfo();
    $admin       = $this->getAdminInfo();
    $acquisition = $this->getAcquisition();

    $this->setAcqId( null );
    $this->setDeletedAt( $cur_time );
    $this->save( $con );
    
    if ($access) {
      $access->delete();
    }
    
    if ($admin) {
      $admin->delete();
    }
    
    return true;
  }
  
  public function getLibraryIds()
  {
    $id = $this->getId();
    
    $c = new Criteria();
    $c->add(EResourcePeer::ID, $id);
    $c->addJoin(EResourcePeer::ACQ_ID, AcquisitionPeer::ID);
    $c->addJoin(AcquisitionPeer::ID, AcqLibAssocPeer::ACQ_ID);
    $c->addJoin(AcqLibAssocPeer::LIB_ID, LibraryPeer::ID);
    $libs = LibraryPeer::doSelect($c);
    $lib_ids = array();
    foreach ($libs as $l) {
      $lib_ids[] = $l->getId();
    }

    return $lib_ids;
  }

  public function getLibraries()
  {
    $c = new Criteria();
    $c->add(EResourcePeer::ID, $this->getId());
    $c->addJoin(EResourcePeer::ACQ_ID, AcquisitionPeer::ID);
    $c->addJoin(AcquisitionPeer::ID, AcqLibAssocPeer::ACQ_ID);
    $c->addJoin(AcqLibAssocPeer::LIB_ID, LibraryPeer::ID);

    return LibraryPeer::doSelect($c);
  }
  
  public function setTitle($v)
  {
    parent::setTitle($v);
    
    // apply stopwords for sorting purposes
    
    $sort_title = $v;
    
    $stopwords = array('the', 'a', 'an');
    foreach ($stopwords as $sw) {
      preg_match("/^$sw\s+(.*)$/i", $v, $matches);
      if ($matches) {
        $sort_title = $matches[1];
      }
    }
    
    $this->setSortTitle($sort_title);
    
    return $this;
  }
  
  public function recordUsageAttempt($user_affiliation, $result, $note = null)
  {
    if ($note && !is_string($note)) {
      throw new Exception('Note must be a string');
    }
    
    if (! is_bool($result) ) {
      throw new Exception('Result indicator must be a boolean');
    }
    
    $session = substr( session_id(), 0, 8 );
    
    $c = new Criteria();
    $c->add( UsageAttemptPeer::ER_ID, $this->getId() );
    $c->add( UsageAttemptPeer::PHPSESSID, $session );
    $c->add( UsageAttemptPeer::AUTH_SUCCESSFUL, $result );
    
    if ( $note ) {
      $c->add( UsageAttemptPeer::NOTE, $note );
    }
    
    if (! $existing_attempt = UsageAttemptPeer::doSelect($c) ) {
      // grab first three octets of user's IP address
      preg_match('/^\d+\.\d+\.\d+(?=\.)/', $_SERVER['REMOTE_ADDR'], $ip_trunc);
      $ip_trunc = $ip_trunc[0];
      
      $usage = new UsageAttempt();
      $usage->setErId( $this->getId() );
      $usage->setPhpsessid( $session );
      $usage->setLibId( $user_affiliation );
      if ($ip_trunc) $usage->setIp($ip_trunc);
      $usage->setDate( time() );
      $usage->setAuthSuccessful($result);
      if ($note) $usage->setNote($note);
      
      $usage->save();
    }
  }
}
