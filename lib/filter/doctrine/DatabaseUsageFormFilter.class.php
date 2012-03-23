<?php

/**
 * DatabaseUsage filter form.
 *
 * @package    freerms
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DatabaseUsageFormFilter extends BaseDatabaseUsageFormFilter
{
  public function configure()
  {
    unset(
      $this['database_id'],
      $this['additional_data']
    );

    $this->widgetSchema['library_id']->setOption('expanded', true);
    $this->widgetSchema['library_id']->setOption('multiple', true);
    $this->widgetSchema['library_id']->setOption('add_empty', false);
    $this->widgetSchema['timestamp']->setLabel('Date');
  }
}
