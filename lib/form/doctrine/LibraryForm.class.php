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
    $this->widgetSchema['ezproxy_algorithm'] = new sfWidgetFormChoice(array(
      'choices' => array(
        'md5' => 'MD5',
        'sha1' => 'SHA1',
      ),
      'expanded' => true,
    ));
    $this->widgetSchema['show_featured']
      ->setLabel('Show featured databases in subjects');

    $this->validatorSchema['ezproxy_algorithm'] = new sfValidatorChoice(array(
      'choices' => array('md5', 'sha1'),
      'required' => false,
    ));
  }
}
