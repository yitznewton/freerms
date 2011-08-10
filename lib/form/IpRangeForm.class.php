<?php

/**
 * IpRange form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class IpRangeForm extends BaseIpRangeForm
{
  public function setup()
  {
    $this->validatorSchema = new freermsValidatorSchemaFixedPost();

    parent::setup();
  }

  public function configure()
  {
    unset(
      $this['updated_at'],
      $this['start_ip_int'],
      $this['end_ip_int']
    );

    $this->setWidget(
      'lib_id',
      new sfWidgetFormPropelChoice(array(
        'model' => 'Library',
        'add_empty' => false,
        'order_by' => array('Name', 'ASC')
      ))
    );
    $this['lib_id']->getWidget()->setLabel('Library');
    $this['start_ip']->getWidget()->setLabel('Starting IP');
    $this['end_ip']->getWidget()->setLabel('Ending IP');
    $this['active_indicator']->getWidget()->setLabel('Active');
    $this['proxy_indicator']->getWidget()->setLabel('Proxy');
    
    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');    

    $this->setValidator( 'start_ip', new freermsValidatorIpAddress() );
    $this->setValidator( 'end_ip',   new freermsValidatorIpAddress() );

    $this->getValidator('lib_id')->setOption('model', 'Library');

    $this->validatorSchema->setPostValidator( new freermsValidatorIpRange() );
  }
}
