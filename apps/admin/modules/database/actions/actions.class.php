<?php

require_once dirname(__FILE__).'/../lib/databaseGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/databaseGeneratorHelper.class.php';

/**
 * database actions.
 *
 * @package    freerms
 * @subpackage database
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class databaseActions extends autoDatabaseActions
{
  public function executeFeatured( sfWebRequest $request )
  {
    $er_params_all = $request->getParameter('EResources');
    
    if ( $er_params_all ) {
      foreach ( $er_params_all as $er_params ) {
        $er = EResourcePeer::retrieveByPK( $er_params['id'] );
        
        $this->forward404Unless( $er );
        
        $er->setFeaturedWeight( $er_params['featured_weight'] );
        $er->save();
      }
    }
    
    $this->form = new FeaturedDbForm();
  }
  
  public function executeAjaxUnfeature( sfWebRequest $request )
  {
    if ( ! $request->isXmlHttpRequest() ) {
      exit();
    }

    $er = EResourcePeer::retrieveByPK( $request->getParameter('id') );

    if ( $er ) {
      $er->setIsFeatured( false );
      $er->save();
    }
    
    $this->getResponse()
      ->setContentType('application/json; charset=utf-8');

    $this->renderText('{}');

    return sfView::NONE;
  }
}
