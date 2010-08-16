<?php

/**
 * library actions.
 *
 * @package    freerms
 * @subpackage library
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class libraryActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {
    if ( ! $request->getParameter('ip') ){
      $this->getResponse()->setContentType('application/json');
      $this->getResponse()->setContent('{}');
      return sfView::NONE;
    }

    $library = LibraryPeer::retrieveByIp( $request->getParameter( 'ip' ) );

    if ($library) {
      $fields = $this->getOutputFields( $library );
    }
    else {
      $fields = array();
    }

    $json_result = json_encode( $fields );

    $this->getResponse()->setContent( $json_result );
    return sfView::NONE;
  }

  protected function getOutputFields( Library $library )
  {
    $output_fields = array(
      'id'   => $library->getId(),
      'name' => $library->getName(),
      'code' => $library->getCode(),
    );

    return $output_fields;
  }
}
