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

    $emails = $this->getObject()->getContactEmails();
    $phones = $this->getObject()->getContactPhones();

    if ( ! $emails ) {
      $email = new ContactEmail();
      $email->setContact($this->getObject());
      $emails[] = $email;
    }

    $this->embedForm( 'emails', $this->createSubform( $emails ) );

    if ( ! $phones ) {
      $phone = new ContactPhone();
      $phone->setContact($this->getObject());
      $phones[] = $phone;
    }

    $this->embedForm( 'phones', $this->createSubform( $phones ) );

    if ($this->getObject()->isNew() || count($phones) <= 1) {
      $this->widgetSchema['emails']->setLabel('Email');
      $this->widgetSchema['phones']->setLabel('Phone number');
    }
    else {
      $this->widgetSchema['emails']->setLabel('Emails');
      $this->widgetSchema['phones']->setLabel('Phone numbers');
    }
  }

  protected function createSubform( array $subobjects )
  {
    $container_form = new sfForm();

    if ( isset( $subobjects[0] ) ) {
      $class = get_class( $subobjects[0] );
      $subform_class = $class . 'Form';
    }
    else {
      throw new InvalidArgumentException( 'Argument must be non-empty array' );
    }

    foreach ( $subobjects as $i => $object ) {
      $subform = new $subform_class( $object );
      unset( $subform['contact_id'] );

      $container_form->embedForm( $i, $subform );

      $widget = new freermsWidgetFormInputDeleteAdd( array(
        'model_id'   => $object->getId(),
        'label'      => false,
        'confirm'    => 'Are you sure?',
      ));

      if ( $i === (count( $subobjects ) - 1) ) {
        $widget->setOption( 'add_text',   'Add' );
        $widget->setOption( 'add_action', 'add' . $class . '()' );  // Javascript
      }

      if ( count( $subobjects ) > 1 ) {
        $widget->setOption( 'delete_text',   'Delete' );
        $widget->setOption( 'delete_action', 'contact/delete' . $class );
      }

      // TODO: this breaks the abstraction; refactor? Have to change schema?

      switch ( $class ) {
        case 'ContactEmail':
          $field_name = 'address';
          break;
        
        case 'ContactPhone':
          $field_name = 'number';
          break;
      }

      $container_form->widgetSchema[$i][$field_name] = $widget;
    }

    return $container_form;
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
    foreach($taintedValues['emails'] as $key => $newEmail) {
      if (!isset($this['emails'][$key])) {
        $this->addEmail($key);
      }
    }

    foreach($taintedValues['phones'] as $key => $newPhone) {
      if (!isset($this['phones'][$key])) {
        $this->addPhone($key);
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  }
}
