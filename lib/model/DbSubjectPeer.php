<?php

class DbSubjectPeer extends BaseDbSubjectPeer
{
  public static function retrieveBySlug( $slug )
  {
    $c = new Criteria();
    $c->add( DbSubjectPeer::SLUG, $slug );
    
    return DbSubjectPeer::doSelectOne( $c );
  }
}
