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
    $this->disableLocalCSRFProtection();

    $this->widgetSchema['library_id']->setOption('expanded', true);
    $this->widgetSchema['library_id']->setOption('multiple', true);
    $this->widgetSchema['library_id']->setOption('add_empty', false);

    $this->widgetSchema['timestamp'] = new sfWidgetFormFilterDate(array(
      'from_date' => new sfWidgetFormDate(array(
        'format' => '%year%%month%',
      )),
      'to_date' => new sfWidgetFormDate(array(
        'format' => '%year%%month%',
      )),
      'with_empty' => false,
    ));

    $this->validatorSchema['library_id'] = new sfValidatorPass();

    $this->validatorSchema['timestamp'] = new sfValidatorDateRange(array(
      'required' => false,
      'from_date' => new freermsValidatorMonth(array(
        'date_format' => '~(?P<year>\d{4})-(?P<month>\d{2})~',
        'required' => false,
        'datetime_output' => 'Y-m',
        'with_time' => false,
      )),
      'to_date' => new freermsValidatorMonth(array(
        'date_format' => '~(?P<year>\d{4})-(?P<month>\d{2})~',
        'required' => false,
        'datetime_output' => 'Y-m',
        'with_time' => false,
      )),
    ));

    unset(
      $this['database_id'],
      $this['additional_data']
    );
  }
}
