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
    $this->widgetSchema['ezproxy_host']->setLabel('EZproxy host');
    $this->widgetSchema['ezproxy_key']->setLabel('EZproxy key');
    $this->widgetSchema['show_featured']
      ->setLabel('Show featured databases in subjects');

    $this->widgetSchema['ezproxy_algorithm']
      = new sfWidgetFormDoctrineEnum(array(
        'model' => 'Library',
        'column' => 'ezproxy_algorithm'));

    $this->validatorSchema['ezproxy_algorithm'] =
      new sfValidatorDoctrineEnum(array(
        'model' => 'Library',
        'column' => 'ezproxy_algorithm'));
  }
}
