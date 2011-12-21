<?php

/**
 * IpRange filter form.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IpRangeFormFilter extends BaseIpRangeFormFilter
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
  }
}
