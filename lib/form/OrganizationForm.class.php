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
    $this->widgetSchema['ip_notification_method_id']->setLabel('IP notification method');
    $this->widgetSchema['ip_notification_force_manual']->setLabel('Manual IP notification');
    $this->widgetSchema['ip_notification_uri']->setLabel('IP notification URI');
    $this->widgetSchema['ip_notification_username']->setLabel('IP notification username');
    $this->widgetSchema['ip_notification_password']->setLabel('IP notification password');
    $this->widgetSchema['ip_notification_contact_id']->setLabel('IP notification contact');

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');
  }
}
