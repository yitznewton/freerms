<?php

/**
 * Library form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class LibraryForm extends BaseLibraryForm
{
  public function configure()
  {
    unset(
      $this['updated_at'],
      $this['acq_lib_assoc_list']
    );
    
    $this->widgetSchema['alt_name']->setLabel('Alternate name');
    $this->widgetSchema['fte']->setLabel('FTE');
    $this->widgetSchema['ezproxy_host']->setLabel('EZproxy host');

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');  
  }
}
