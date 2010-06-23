<?php

/**
 * Contact form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
class ContactForm extends BaseContactForm
{
  public function configure()
  {
    unset(
      $this['updated_at'],
      $this['auto_email_ip_reg_event_list'],
      $this['manual_email_ip_reg_event_list']
    );

    $this->widgetSchema['org_id']->setLabel('Organization');

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');

    $email_container_form = new sfForm();   
    $emails = $this->getObject()->getContactEmails();

    foreach ( $emails as $i => $email ) {
      $email_form = new ContactEmailForm( $email ); 

      unset( $email_form['contact_id'] );
      $email_container_form->embedForm( $i, $email_form );     
    }
    
    $this->embedForm( 'emails', $email_container_form );
    $this->widgetSchema['emails']->setLabel('Emails');

    $phone_container_form = new sfForm();
    $phones = $this->getObject()->getContactPhones();

    foreach ( $phones as $i => $phone ) {
      $phone_form = new ContactPhoneForm( $phone );      

      unset( $phone_form['contact_id'] );
      $phone_container_form->embedForm( $i, $phone_form );
    }

    $this->embedForm( 'phones', $phone_container_form );
    $this->widgetSchema['phones']->setLabel('Phone numbers');    
  }
}
