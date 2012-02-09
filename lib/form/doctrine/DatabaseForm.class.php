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
      $this['featured_weight'],
      $this['created_at'],
      $this['updated_at'],
      $this['deleted_at']
    );

    $this->widgetSchema['alt_id']->setLabel('Alternate ID');
    $this->widgetSchema['access_url']->setLabel('URL');
    $this->widgetSchema['is_hidden']->setLabel('Hidden');
    $this->widgetSchema['is_unavailable']->setLabel('Unavailable');
    $this->widgetSchema['is_featured']->setLabel('Feature on homepage');
 
    $this->widgetSchema['access_action_onsite']
      ->setLabel('Onsite access action');

    $lister = new freermsAccessActionLister(
      sfConfig::get('sf_apps_dir') . '/frontend/modules/access/actions');

    $this->widgetSchema['access_action_onsite'] = new sfWidgetFormChoice(array(
      'label' => 'Onsite access action',
      'choices' => $lister->retrieve(freermsAccessActionLister::ONSITE),
    ));

    $this->setDefault('access_action_onsite',
      $this->getObject()->isNew()
        ? 'baseAccessAction'
        : $this->getObject()->getAccessActionOnsite());

    $this->widgetSchema['access_action_offsite'] = new sfWidgetFormChoice(array(
      'label' => 'Onsite access action',
      'choices' => $lister->retrieve(freermsAccessActionLister::OFFSITE),
    ));

    $this->setDefault('access_action_offsite',
      $this->getObject()->isNew()
        ? 'ezproxyAccessAction'
        : $this->getObject()->getAccessActionOffsite());

    $this->widgetSchema['libraries_list']
      ->setLabel('Libraries')
      ->setOption('expanded', true)
      ->setOption('order_by', array('name', 'asc'));
 
    $this->widgetSchema['subjects_list']
      ->setLabel('Subjects')
      ->setOption('expanded', true)
      ->setOption('order_by', array('name', 'asc'));

    $this->validatorSchema['sort_title']->setOption('required', false);

    $this->validatorSchema['additional_fields'] = new freermsValidatorYaml(array(
      'required' => false,
    ));

    $this->validatorSchema['access_control'] = new freermsValidatorYaml(array(
      'required' => false,
    ));

    $this->validatorSchema->setPostValidator(
      new freermsValidatorDatabaseSortTitle());
  }
}

