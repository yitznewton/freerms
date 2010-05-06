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
    
    $this->widgetSchema['acq_lib_assoc_list']
      = new freermsWidgetFormSelectCheckboxLink(array(
      'choices' => $libs,
      'url' => $url,
      'linkText' => 'Edit'
    ));
    
    $this->widgetSchema->setLabel('acq_lib_assoc_list', ' ');

    $vendor_org_id = $this->getObject()->getVendorOrgId();

    // add an empty element to choices
    $orgs = OrganizationPeer::retrieveKeyedArray();
    $orgs = array('' => '') + $orgs;
    
    $add_url = sfContext::getInstance()->getController()->
      genUrl('organization/new');    
    $edit_url = sfContext::getInstance()->getController()->
      genUrl('organization/edit?id='.$vendor_org_id);

    if ($vendor_org_id){
      $this->widgetSchema['vendor_org_id']
        = new freermsWidgetFormChoiceLink(array(
        'choices' => $orgs,
        'link_urls' => array('Edit' => $edit_url, 'Add new' => $add_url)
      ));
    }
    else {
      $this->widgetSchema['vendor_org_id']
        = new freermsWidgetFormChoiceLink(array(
        'choices' => $orgs,
        'link_urls' => array('Add new' => $add_url)
      ));
    }
   
    $this->validatorSchema['vendor_org_id'] = new sfValidatorChoice(array(
      'choices' => array_keys($orgs),
      'required' => false
    ));

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $decorator->setRowFormat(
      "<div class=\"form-row form-row-checkbox\">\n  %error%%label%"
      ."\n  %field%%help%\n%hidden_fields%</div>\n"
    );
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');
  }
}
