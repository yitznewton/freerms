<?php

/**
 * ContactEmail form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
class ContactEmailForm extends BaseContactEmailForm
{
  public function configure()
  {
    $this->widgetSchema['address']->setLabel( false );

    $this->setValidator('address', new sfValidatorString(array('required' => false)));

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');
  }
}
