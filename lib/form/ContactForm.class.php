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
              'confirm' => 'Are you sure?',
            ));

          if ($i === (count($emails)-1)){

            $email_container_form->widgetSchema[$i]['address'] =
              new freermsWidgetFormInputDeleteAdd(array(
                'delete_text' => 'Delete',
                'delete_action' => 'contact/deleteEmail',
                'model_id' => $email->getId(),
                'confirm' => 'Are you sure?',
                'add_text' => 'Add',
                'add_action' => 'addEmail()',  // Javascript
              ));
          }
        }
        
        else{
          
          $email_container_form->widgetSchema[$i]['address'] =
            new freermsWidgetFormInputDeleteAdd(array(
              'add_text' => 'Add',
              'add_action' => 'addEmail()',  // Javascript
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
   
    $phone_container_form = new sfForm();
    $phones = $this->getObject()->getContactPhones();

    if (!$phones){
      $phone = new ContactPhone();
      $phone->setContact($this->getObject());
      $phones[] = $phone;
    }

    foreach ( $phones as $i => $phone ) {
      $phone_form = new ContactPhoneForm( $phone );

      unset( $phone_form['contact_id'] );
      $phone_container_form->embedForm( $i, $phone_form );

       if (!$this->getObject()->isNew()){

        if (count($phones) > 1){

          $phone_container_form->widgetSchema[$i]['number'] =
            new freermsWidgetFormInputDeleteAdd(array(
              'delete_text' => 'Delete',
              'delete_action' => 'contact/deletePhone',
              'model_id' => $phone->getId(),
              'confirm' => 'Are you sure?',
            ));

          if ($i === (count($phones)-1)){

            $phone_container_form->widgetSchema[$i]['number'] =
              new freermsWidgetFormInputDeleteAdd(array(
                'delete_text' => 'Delete',
                'delete_action' => 'contact/deletePhone',
                'model_id' => $phone->getId(),
                'confirm' => 'Are you sure?',
                'add_text' => 'Add',
                'add_action' => 'addPhone()',  // Javascript
              ));
          }
        }

        else{

          $phone_container_form->widgetSchema[$i]['number'] =
            new freermsWidgetFormInputDeleteAdd(array(
              'add_text' => 'Add',
              'add_action' => 'addPhone()',  // Javascript
            ));
        }
      }
      
      $phone_container_form->widgetSchema[$i]['number']->setLabel(' ');
    }

    $this->embedForm( 'phones', $phone_container_form );

    if ($this->getObject()->isNew() || count($phones) <= 1){
      $this->widgetSchema['phones']->setLabel('Phone number');
    }
    else {
      $this->widgetSchema['phones']->setLabel('Phone numbers');
    }   
  }

  public function addEmail($index)
  {
    $email = new ContactEmail();
    $email->setContact($this->getObject());

    $this->embeddedForms['emails']->embedForm($index, new ContactEmailForm($email));
    $this->embedForm('emails', $this->embeddedForms['emails']);

    $this->widgetSchema['emails'][$index]['contact_id'] = new sfWidgetFormInputHidden();
  }

  public function addPhone($index)
  {
    $phone = new ContactPhone();
    $phone->setContact($this->getObject());

    $this->embeddedForms['phones']->embedForm($index, new ContactPhoneForm($phone));
    $this->embedForm('phones', $this->embeddedForms['phones']);

    $this->widgetSchema['phones'][$index]['contact_id'] = new sfWidgetFormInputHidden();
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {    
    foreach($taintedValues['emails'] as $key => $newEmail)
    {            
      if (!($newEmail['address'])){

        unset($taintedValues['emails'][$key]);

        unset($this->embeddedForms['emails']['address']);
      }
      
      elseif (!isset($this['emails'][$key])){

        $this->addEmail($key);
      }
    }

    foreach($taintedValues['phones'] as $key => $newPhone)
    {
      if (!($newPhone['number'])){

        unset($taintedValues['phones'][$key]);

        unset($this->embeddedForms['phones']['number']);
      }

      elseif (!isset($this['phones'][$key])){

        $this->addPhone($key);
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  } 
}
