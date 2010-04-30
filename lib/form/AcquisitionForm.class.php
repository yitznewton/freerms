<?php

/**
 * Acquisition form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AcquisitionForm extends BaseAcquisitionForm
{
  public function configure()
  {        
    unset(
      $this->widgetSchema['note'],
      $this->validatorSchema['note']
    );
        
    $libs = LibraryPeer::retrieveKeyedArray();
    $url = sfContext::getInstance()->getController()->
      genUrl('library/edit?id=');
    
    $this->widgetSchema['vendor_org_id']->setLabel('Vendor');

    $this->widgetSchema['acq_lib_assoc_list']
      = new freermsWidgetFormSelectCheckboxLink(array(
      'choices' => $libs,
      'url' => $url,
      'linkText' => 'Edit'
    ));
    
    $this->widgetSchema->setLabel('acq_lib_assoc_list', ' '); 

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $decorator->setRowFormat(
      "<div class=\"form-row form-row-checkbox\">\n  %error%%label%"
      ."\n  %field%%help%\n%hidden_fields%</div>\n"
    );
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');

  }
}
