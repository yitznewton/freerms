<?php

/**
 * Library form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LibraryForm extends BaseLibraryForm
{
  public function configure()
  {
    unset(
      $this['databases_list'],
      $this['created_at'],
      $this['updated_at'],
      $this['deleted_at']
    );

    $this->widgetSchema['ezproxy_host']->setLabel('EZproxy host');
    $this->widgetSchema['ezproxy_key']->setLabel('EZproxy key');
    $this->widgetSchema['show_featured']
      ->setLabel('Show featured databases in subjects');

    $this->widgetSchema['ezproxy_algorithm']
      = new sfWidgetFormDoctrineEnum(array(
        'table' => Doctrine_Core::getTable('Library'),
        'column' => 'ezproxy_algorithm'));

    $this->validatorSchema['ezproxy_algorithm'] =
      new sfValidatorDoctrineEnum(array(
        'table' => Doctrine_Core::getTable('Library'),
        'column' => 'ezproxy_algorithm'));
  }
}

