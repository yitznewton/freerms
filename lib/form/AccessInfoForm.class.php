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
    unset($this['deleted_at']);
    
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
    if ( $site != 'offsite' && $site != 'onsite' ) {
      $msg = '$site must be either offsite or onsite';
      throw new InvalidArgumentException( $msg );
    }

    BaseAccessHandler::loadClasses();

    $access_handlers = array();

    foreach ( get_declared_classes() as $class ) {
      if (
        substr( $class, -13 ) == 'AccessHandler'
        && substr( $class, 0, 6 ) != 'Script'
      ) {
        if (
          ( $site == 'offsite' && ! $class::IS_VALID_OFFSITE )
          || ( $site == 'onsite' && ! $class::IS_VALID_ONSITE )
        ) {
          break;
        }

        $access_handlers[ $class ] = $class::DESCRIPTION;
      }
    }

    $id = $this->getObject()->getId();

    if (
      $this->getObject()
      && class_exists( 'AccessInfo' . $id . 'AccessHandler' )
      &&  ( $site == 'offsite' && $class::IS_VALID_OFFSITE )
          || ( $site == 'onsite' && $class::IS_VALID_ONSITE )
    ) {
      $class = 'AccessInfo' . $id . 'AccessHandler';
      $access_handlers[ $class ] = $class::DESCRIPTION;
    }

    asort( $access_handlers );

    return $access_handlers;
  }
}
