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

    if (!$emails){ 
      $email = new ContactEmail();
      $email->setContact($this->getObject()); 
      $emails[] = $email;     
    }
   
    foreach ( $emails as $i => $email ) {
      $email_form = new ContactEmailForm( $email );

      unset( $email_form['contact_id'] );
      $email_container_form->embedForm( $i, $email_form );

      if (!$this->getObject()->isNew()){

        if (count($emails) > 1){

          $email_container_form->widgetSchema[$i]['address'] =
            new freermsWidgetFormInputDeleteAdd(array(
              'delete_text' => 'Delete',
              'delete_action' => 'contact/deleteEmail',
              'model_id' => $email->getId(),
              'confirm' => 'Are you sure???',
            ));

          if ($i === (count($emails)-1)){

            $email_container_form->widgetSchema[$i]['address'] =
              new freermsWidgetFormInputDeleteAdd(array(
                'delete_text' => 'Delete',
                'delete_action' => 'contact/deleteEmail',
                'model_id' => $email->getId(),
                'confirm' => 'Are you sure???',
                'add_text' => 'Add',
                'add_action' => 'add_email()',
              ));
          }
        }
        
        else{
          
          $email_container_form->widgetSchema[$i]['address'] =
            new freermsWidgetFormInputDeleteAdd(array(
              'add_text' => 'Add',
              'add_action' => 'add_email()',
            ));
        }
        
      } 
      
      $email_container_form->widgetSchema[$i]['address']->setLabel(' ');
    }
    
    $this->embedForm( 'emails', $email_container_form );

    if ($this->getObject()->isNew() || count($emails) <= 1){
      $this->widgetSchema['emails']->setLabel('Email');
    }
    else {
      $this->widgetSchema['emails']->setLabel('Emails');
    }
   
   

//    $phone_container_form = new sfForm();
//    $phones = $this->getObject()->getContactPhones();
//
//    foreach ( $phones as $i => $phone ) {
//      $phone_form = new ContactPhoneForm( $phone );
//
//      unset( $phone_form['contact_id'] );
//      $phone_container_form->embedForm( $i, $phone_form );
//    }
//
//    $this->embedForm( 'phones', $phone_container_form );
//    $this->widgetSchema['phones']->setLabel('Phone numbers');
  }

  public function addEmail($num)
  {
    $email = new ContactEmail();
    $email->setContact($this->getObject());

    $this->embeddedForms['emails']->embedForm($num, new ContactEmailForm($email));
    $this->embedForm('emails', $this->embeddedForms['emails']);

    $this->widgetSchema['emails'][$num]['contact_id'] = new sfWidgetFormInputHidden();
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    foreach($taintedValues['emails'] as $key => $t)
    {
      if (!isset($this['emails'][$key]))
      {
        $this->addEmail($key);
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  }
}
