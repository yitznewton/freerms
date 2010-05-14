<?php

require 'lib/model/om/BaseContactPeer.php';

class ContactPeer extends BaseContactPeer {

  public static function retrieveByOrgId($id, Criteria $c = null)
  {
    if (!$c) {
      $c = new Criteria();
    }

    $c->add(OrganizationPeer::ID, $id);
    $c->addAscendingOrderByColumn(ContactPeer::LAST_NAME);
    $c->addJoin(OrganizationPeer::ID, ContactPeer::ORG_ID);

    return ContactPeer::doSelect($c);
  }
}

