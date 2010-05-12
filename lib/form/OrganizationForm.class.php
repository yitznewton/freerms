<?php

/**
 * Organization form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 */
class OrganizationForm extends BaseOrganizationForm
{
  public function configure()
  {
    unset( $this['updated_at'] );

    $this->widgetSchema['alt_name']->setLabel('Alternate name');

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');
  }
}
