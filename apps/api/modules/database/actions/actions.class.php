<?php

/**
 * database actions.
 *
 * @package    freerms
 * @subpackage database
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class databaseActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(EResourcePeer::TITLE);

    if ( $lib_code = $request->getParameter('library') ) {
      $c->addJoin(EResourcePeer::ACQ_ID, AcquisitionPeer::ID);
      $c->addJoin(AcquisitionPeer::ID, AcqLibAssocPeer::ACQ_ID);
      $c->addJoin(AcqLibAssocPeer::LIB_ID, LibraryPeer::ID);
      $c->add(LibraryPeer::CODE, $lib_code);
    }

    if ( $subject = $request->getParameter('subject') ) {
      $c->addJoin(EResourcePeer::ID, EResourceDbSubjectAssocPeer::ER_ID);
      $c->addJoin(EResourceDbSubjectAssocPeer::DB_SUBJECT_ID, DbSubjectPeer::ID);
      $c->add(DbSubjectPeer::LABEL, $subject);
    }

    $ers = EResourcePeer::doSelect( $c );
    
    $results = array();

    foreach ($ers as $er) {
      $results[] = $this->getOutputFields( $er, false );
    }
    
    $json_result = json_encode( $results );

    $this->getResponse()->setContent( $json_result );

    return sfView::NONE;
  }

  public function executeShow(sfWebRequest $request)
  {
    if (! $request->getParameter('id')){
      $this->getResponse()->setContentType('application/json');
      $this->getResponse()->setContent('{}');
      return sfView::NONE;
    }
       
    $c = new Criteria();
    $c->add(EResourcePeer::ID, $request->getParameter('id'));
    $c->add(EResourcePeer::SUPPRESSION, 'false');   
       
    $eresource = EResourcePeer::doSelectOne($c);

    if ($eresource) {
      $fields = $this->getOutputFields( $eresource );
    }
    else {
      $fields = array(); 
    }

    $json_result = json_encode( $fields );

    $this->getResponse()->setContent( $json_result );
    return sfView::NONE;
  }

  protected function getOutputFields( EResource $eresource, $retrieve_foreign = true )
  {
    $output_fields = array(
      'id'          => $eresource->getId(),
      'title'       => $eresource->getTitle(),
      'alt_title'   => $eresource->getAltTitle(),
      'description' => $eresource->getDescription(),
      'uri'         => $eresource->getUserUrl(),
      'public_note' => $eresource->getPublicNote(),
      'unavailable' => $eresource->getProductUnavailable(),
    );

    if ( $retrieve_foreign ) {
      $subjectAssocs = $eresource->getEResourceDbSubjectAssocsJoinDbSubject();

      $output_fields['libraries'] = array();
      $output_fields['subjects']  = array();

      foreach ($subjectAssocs as $subjectAssoc){
        $output_fields['subjects'][] = $subjectAssoc->getDbSubject()->getLabel();
      }

      foreach ($eresource->getLibraries() as $l) {
        $output_fields['libraries'][] = $l->getCode();
      }
    }

    return $output_fields;
  }
}
