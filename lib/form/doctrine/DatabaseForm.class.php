<?php

/**
 * Database form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DatabaseForm extends BaseDatabaseForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at']
    );

    $this->widgetSchema['alt_id']->setLabel('Alternate ID');
    $this->widgetSchema['access_url_onsite']->setLabel('Onsite URL');
    $this->widgetSchema['access_url_offsite']->setLabel('Offsite URL');
    $this->widgetSchema['is_hidden']->setLabel('Hidden');
    $this->widgetSchema['is_unavailable']->setLabel('Unavailable');
    $this->widgetSchema['is_featured']->setLabel('Feature on homepage');
 
    $this->widgetSchema['access_handler_onsite']
      ->setLabel('Onsite access handler');

    $this->widgetSchema['access_handler_offsite']
      ->setLabel('Offsite access handler');
 
    $this->widgetSchema['libraries_list']
      ->setLabel('Libraries')
      ->setOption('expanded', true);
 
    $this->widgetSchema['subjects_list']
      ->setLabel('Subjects')
      ->setOption('expanded', true);

    $this->validatorSchema['sort_title']->setOption('required', false);

    $this->validatorSchema->setPostValidator(
      new freermsValidatorDatabaseSortTitle());
  }
}

