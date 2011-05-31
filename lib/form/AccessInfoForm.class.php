<?php

/**
 * AccessInfo form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AccessInfoForm extends BaseAccessInfoForm
{
  public function configure()
  {
    unset(
      $this['deleted_at']
    );
    
    $this->widgetSchema['ezproxy_cfg_entry']
      ->setLabel('ezproxy.cfg entry');
    $this->widgetSchema['referral_note']
      ->setLabel('User note on referral');

    $onsite_handlers  = $this->getAccessHandlers( 'onsite' );
    $offsite_handlers = $this->getAccessHandlers( 'offsite' );

    $this->widgetSchema['onsite_access_handler'] = new sfWidgetFormChoice (
      array( 'choices' => $onsite_handlers, )
    );

    if ( $this->getObject()->getOnsiteAccessHandler() ) {
      $this->widgetSchema['onsite_access_handler']->setDefault(
        $this->getObject()->getOnsiteAccessHandler()
      );
    }
    else {
      $this->widgetSchema['onsite_access_handler']->setDefault(
        sfConfig::get( 'app_access_default-handler-onsite' )
      );
    }

    $this->widgetSchema['offsite_access_handler'] = new sfWidgetFormChoice(
      array( 'choices' => $offsite_handlers, )
    );

    if ( $this->getObject()->getOffsiteAccessHandler() ) {
      $this->widgetSchema['offsite_access_handler']->setDefault(
        $this->getObject()->getOffsiteAccessHandler()
      );
    }
    else {
      $this->widgetSchema['offsite_access_handler']->setDefault(
        sfConfig::get( 'app_access_default-handler-offsite' )
      );
    }

    $this->validatorSchema['onsite_access_handler'] = new sfValidatorChoice(
      array( 'choices' => array_keys( $onsite_handlers ), )
    );

    $this->validatorSchema['offsite_access_handler'] = new sfValidatorChoice(
      array( 'choices' => array_keys( $offsite_handlers ), )
    );

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');
  }

  protected function getAccessHandlers( $site )
  {
    switch ( $site ) {
      case 'onsite':
        $access_handlers = BaseAccessHandler::getOnsiteHandlers();
        break;
      
      case 'offsite':
        $access_handlers = BaseAccessHandler::getOffsiteHandlers();
        break;
      
      default:
        $msg = '$site must be either offsite or onsite';
        throw new InvalidArgumentException( $msg );
    }
    
    if ( $this->getObject() ) {
      $id = $this->getObject()->getId();
      
      $custom_class_name = 'AccessInfo' . $id . 'AccessHandler';

      if (
        class_exists( $custom_class_name )
        &&  ( $site == 'offsite' && $custom_class_name::IS_VALID_OFFSITE )
            || ( $site == 'onsite' && $custom_class_name::IS_VALID_ONSITE )
      ) {
        $class = 'AccessInfo' . $id . 'AccessHandler';
        $access_handlers[ $custom_class_name ] = 'Custom';
      }
    }
    
    return $access_handlers;
  }
}
