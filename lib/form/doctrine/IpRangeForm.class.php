<?php

/**
 * IpRange form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IpRangeForm extends BaseIpRangeForm
{
  public function configure()
  {
    unset(
      $this['start_ip_sort'],
      $this['end_ip_sort']
    );

    $this->widgetSchema['start_ip']->setLabel('Start IP');
    $this->widgetSchema['end_ip']->setLabel('End IP');
    $this->widgetSchema['is_active']->setLabel('Active');
    $this->widgetSchema['is_excluded']->setLabel('Excluded');

    $this->validatorSchema['start_ip'] = new freermsValidatorIpAddress();
    $this->validatorSchema['end_ip'] = new freermsValidatorIpAddress();

    $this->validatorSchema->setPostValidator(new freermsValidatorIpRange());
  }
}

