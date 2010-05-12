<?php

/**
 * Organization form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
class OrganizationForm extends BaseOrganizationForm
{
  public function configure()
  {
    unset( $this['updated_at'] );

    $this->widgetSchema['alt_name']->setLabel('Alternate name');
    $this->widgetSchema['ip_reg_method_id']->setLabel('IP registration method');
    $this->widgetSchema['ip_reg_force_manual']->setLabel('Always do manual IP registration');
    $this->widgetSchema['ip_reg_uri']->setLabel('IP registration URI');
    $this->widgetSchema['ip_reg_username']->setLabel('IP registration username');
    $this->widgetSchema['ip_reg_password']->setLabel('IP registration password');

    $contact_criteria = new Criteria();
    $contact_criteria->add( ContactPeer::ORG_ID, $this->getObject()->getId() );

    $this->widgetSchema['ip_reg_contact_id'] = new sfWidgetFormPropelChoice( array(
      'label'     => 'IP registration contact',
      'model'     => 'Contact',
      'add_empty' => true,
      'criteria'  => $contact_criteria,
    ) );

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');
  }
}
