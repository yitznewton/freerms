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

    $this->addSubformContainer( 'ContactEmail' );
    $this->addSubformContainer( 'ContactPhone' );

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

  public function addSubform( $class, $index )
  {
    $container = $class . 's';
    $form_class = $class . 'Form';
    
    $subobject = new $class();
    $subobject->setContact( $this->getObject() );

    $getter  = 'get' . $class . 's';
    $objects = $this->getObject()->$getter();

    $widget = new freermsWidgetFormInputDeleteAdd2( array(
      'label' => false,
    ));

    $widget->setIndex( $index );
    $widget->setObjects( $objects );
    $widget->setOption( 'delete_attributes', array( 'class' => 'input-link input-link-delete' ) );

    // TODO: this breaks the abstraction; refactor? Have to change schema?

    switch ( $class ) {
      case 'ContactEmail':
        $field_name = 'address';
        break;

      case 'ContactPhone':
        $field_name = 'number';
        break;
    }
    
    $this->embeddedForms[$container]->embedForm( $index, new $form_class( $subobject ) );
    $this->embedForm( $container, $this->embeddedForms[$container] );

    $this->widgetSchema[$container][$index][$field_name] = $widget;
    $this->widgetSchema[$container][$index]['contact_id'] = new sfWidgetFormInputHidden();
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    foreach ( $taintedValues['ContactEmails'] as $index => $contact_email ) {
      if ( ! isset( $this['ContactEmails'][$index] ) ) {
        $this->addSubform( 'ContactEmail', $index );
      }
    }

    foreach ( $taintedValues['ContactPhones'] as $index => $contact_phone ) {
      if ( ! isset( $this['ContactPhones'][$index] ) ) {
        $this->addSubform( 'ContactPhone', $index );
      }
    }

    parent::bind( $taintedValues, $taintedFiles );
  }

  protected function addSubformContainer( $subobject_class )
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

    $widget = new freermsWidgetFormInputDeleteAdd2( array(
      'label'          => false,
    ));

    $widget->setObjects( $subobjects );

    foreach ( $subobjects as $i => $object ) {
      $subform = new $subform_class( $object );
      unset( $subform['contact_id'] );

      $container_form->embedForm( $i, $subform );

      $widget->setIndex( $i );

      $widget->setOption( 'delete_attributes', array(
        'class' => 'input-link input-link-delete',
      ) );

      $widget->setOption( 'add_attributes', array(
        'class'   => 'input-link input-link-add',
      ) );

      $widget->setOption( 'delete_action', 'contact/delete' . $class );

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

  protected function pruneEmbedded( $class, array &$taintedValues )
  {
    $container = $class . 's';

    if ( ! isset( $taintedValues[$container] ) ) {
      throw new InvalidArgumentException( 'No such container' );
    }

    switch ( $class ) {
      case 'ContactEmail':
        $fieldname = 'address';
        break;

      case 'ContactPhone':
        $fieldname = 'number';
        break;
    }

    $keys_to_unset = array();

    foreach ( $taintedValues[$container] as $key => $object ) {
      if ( ! $object[$fieldname] ) {
        $keys_to_unset[] = $key;
      }
      elseif ( ! isset( $this[$container][$key] ) ) {
        $this->addSubform( $class, $key );
      }
    }

    foreach ( $keys_to_unset as $key ) {
      unset( $taintedValues[$container][$key] );
      unset( $this->embeddedForms[$container][$key] );
    }
  }
}
