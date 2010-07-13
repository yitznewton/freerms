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

    $this->addSubform( 'ContactEmail' );
    $this->addSubform( 'ContactPhone' );

    $contact = $this->getObject();

    if ( $contact->isNew() || count( $contact->getContactEmails() ) <= 1) {
      $this->widgetSchema['ContactEmails']->setLabel('Email');
    }
    else {
      $this->widgetSchema['ContactEmails']->setLabel('Emails');
    }

    if ( $contact->isNew() || count( $contact->getContactPhones() ) <= 1) {
      $this->widgetSchema['ContactPhones']->setLabel('Phone number');
    }
    else {
      $this->widgetSchema['ContactPhones']->setLabel('Phone numbers');
    }
  }

  protected function addSubform( $subobject_class )
  {
    $getter = 'get' . $subobject_class . 's';

    if ( ! method_exists( $this->getObject(), $getter ) ) {
      throw new InvalidArgumentException( 'Invalid class' );
    }

    $subobjects = $this->getObject()->$getter();

    if ( ! $subobjects ) {
      $object = new $subobject_class();
      $object->setContact( $this->getObject() );
      $subobjects = array( $object );
    }

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

    $this->embedForm( $subobject_class . 's', $container_form );
  }

  public function addEmail($index)
  {
    $email = new ContactEmail();
    $email->setContact($this->getObject());

    $this->embeddedForms['ContactEmails']->embedForm($index, new ContactEmailForm($email));
    $this->embedForm('ContactEmails', $this->embeddedForms['ContactEmails']);

    $this->widgetSchema['ContactEmails'][$index]['contact_id'] = new sfWidgetFormInputHidden();
  }

  public function addPhone($index)
  {
    $phone = new ContactPhone();
    $phone->setContact($this->getObject());

    $this->embeddedForms['ContactPhones']->embedForm($index, new ContactPhoneForm($phone));
    $this->embedForm('ContactPhones', $this->embeddedForms['ContactPhones']);

    $this->widgetSchema['ContactPhones'][$index]['contact_id'] = new sfWidgetFormInputHidden();
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    foreach($taintedValues['ContactEmails'] as $key => $newEmail) {
      if (!isset($this['ContactEmails'][$key])) {
        $this->addEmail($key);
      }
    }

    foreach($taintedValues['ContactPhones'] as $key => $newPhone) {
      if (!isset($this['ContactPhones'][$key])) {
        $this->addPhone($key);
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  }
}
