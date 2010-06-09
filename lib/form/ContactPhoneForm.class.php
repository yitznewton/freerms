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

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');
  }
}
