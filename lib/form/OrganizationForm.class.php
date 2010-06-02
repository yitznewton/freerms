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
    $this->widgetSchema['web_admin_uri']->setLabel('Web admin URI');
    $this->widgetSchema['web_admin_username']->setLabel('Web admin username');
    $this->widgetSchema['web_admin_password']->setLabel('Web admin password');

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
