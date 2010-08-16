<?php

/**
 * ContactPhone form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
class ContactPhoneForm extends BaseContactPhoneForm
{
  public function configure()
  {
    $this->widgetSchema['number']->setLabel( false );

    $this->setValidator('number', new sfValidatorString(array('required' => false)));

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');    
  }
}
