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

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $this->pruneEmbedded( 'ContactEmail', $taintedValues );
    $this->pruneEmbedded( 'ContactPhone', $taintedValues );

    parent::bind( $taintedValues, $taintedFiles );
  }

  public function addSubformContainer( $subobject_class, $index = null )
  {
    if ( isset( $index ) && ! is_int( $index ) ) {
      $msg = 'Second argument must be an integer';
      throw new InvalidArgumentException( $msg );
    }

    $container_name = $subobject_class . 's';
    $getter         = 'get' . $subobject_class . 's';
    $subform_class  = $subobject_class . 'Form';

    if ( ! method_exists( $this->getObject(), $getter ) ) {
      throw new InvalidArgumentException( 'Invalid class' );
    }

    $subobjects = $this->getObject()->$getter();

    if ( isset( $index ) ) {
      $new_subobject = new $subobject_class();
      $new_subobject->setContact( $this->getObject() );
      $subobjects[$index] = $new_subobject;
    }
    elseif ( ! $subobjects ) {
      $new_subobject = new $subobject_class();
      $new_subobject->setContact( $this->getObject() );
      $subobjects[] = $new_subobject;
    }

    $container_form = new sfForm();

    $widget = new freermsWidgetFormInputDeleteAdd2( array(
      'label' => false,
      'delete_attributes' => array(
        'class' => 'input-link input-link-delete',
      ),
      'add_attributes' => array(
        'class'   => 'input-link input-link-add',
      ),
    ));

    $widget->setObjects( $subobjects );

    foreach ( $subobjects as $i => $subobject ) {
      $aWidget = clone $widget;

      if ( $subobject->isNew() ) {
        $aWidget->setOption( 'delete_action', null );
      }
      else {
        $action = 'contact/delete' . $subobject_class;
        $aWidget->setOption( 'delete_action', $action );
      }

      $subform = new $subform_class( $subobject );
      unset( $subform['contact_id'] );

      $container_form->embedForm( $i, $subform );

      $aWidget->setIndex( $i );

      // TODO: freermsSimpleAssoc::getDataFieldName() is a bit of a kluge;
      // modify?
      if ( ! $subobject instanceof freermsSimpleAssoc ) {
        $msg = '$subobject class does not implement freermsSimpleAssoc';
        throw new Exception( $msg );
      }

      $container_form->widgetSchema[$i][$subobject->getDataFieldName()] = $aWidget;
    }

    $this->embedForm( $container_name, $container_form );
  }

  /**
   * Removes unused embedded forms and clears associated objects to avoid
   * incorrectly adding blank associated objects
   *
   * @param string $class
   * @param array $taintedValues 
   */
  protected function pruneEmbedded( $class, array &$taintedValues )
  {
    $container = $class . 's';

    if ( ! isset( $taintedValues[$container] ) ) {
      throw new InvalidArgumentException( 'No such container' );
    }

    $clearer   = 'clear' . $class . 's';
    $subobject = new $class();

    $this->getObject()->$clearer();

    $keys_of_blank_subobjects = array();

    foreach ( $taintedValues[$container] as $key => $record ) {
      if (
        $subobject instanceof freermsSimpleAssoc
        && ! $record[ $subobject->getDataFieldName() ]
      ) {
        $keys_of_blank_subobjects[] = $key;
      }
      elseif ( ! isset( $this[$container][$key] ) ) {
        $this->addSubformContainer( $class, $key );
      }
    }

    foreach ( $keys_of_blank_subobjects as $key ) {
      $tainted_record = $taintedValues[$container][$key];

      if ( isset( $tainted_record['id'] ) ) {
        $peer_class = $class . 'Peer';
        $c = new Criteria();
        $c->add( constant( $peer_class . '::ID' ), $tainted_record['id'] );
        call_user_func( $peer_class . '::doDelete', $c );
      }
      
      unset( $taintedValues[$container][$key] );
      unset( $this->embeddedForms[$container][$key] );
    }
  }
}
