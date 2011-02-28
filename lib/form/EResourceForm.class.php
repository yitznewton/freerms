<?php

/**
 * EResource form.
 *
 * @package    erms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EResourceForm extends BaseEResourceForm
{
  public function configure()
  {
    unset(      
      $this['sort_title'],
      $this['access_info_id'],
      $this['acq_id'],
      $this['admin_info_id'],
      $this['created_at'],
      $this['updated_at'],
      $this['deleted_at']
    );
    
    $this->widgetSchema['alt_id']->setLabel('Alternate ID');
    $this->widgetSchema['alt_title']->setLabel('Alternate title');
    $this->widgetSchema['suppression']->setLabel('Suppress display');
    $this->widgetSchema['e_resource_db_subject_assoc_list']
      ->setLabel('Subjects')
      ->setOption('expanded', true);

    $c = new Criteria();
    $c->addAscendingOrderByColumn(DbSubjectPeer::LABEL);

    $this->widgetSchema['e_resource_db_subject_assoc_list']
      ->setOption('criteria', $c);
    
    freermsActions::embedForm($this, 'AccessInfo');
    freermsActions::embedForm($this, 'Acquisition');   
    freermsActions::embedForm($this, 'AdminInfo');   

    $subject_container_form = new sfForm();

    foreach ( $this->getObject()->getEResourceDbSubjectAssocs() as $esa ) {
      $form = new EResourceDbSubjectAssocForm( $esa );
      $subject_container_form->embedForm( $esa->getDbSubjectId(), $form );
    }

    $this->embedForm( 'EResourceDbSubjectAssocs', $subject_container_form );

    $lang_url = 'http://www.loc.gov/marc/languages/language_name.html';
    $this->widgetSchema['language']
      = new freermsWidgetFormInputLink(
        array(
          'url' => $lang_url,
          'target' => '_blank',
          'linkText' => 'Open code list',
        )
      );

    $this->setValidator('language', new sfValidatorRegex(array(
      'pattern' => '/^([a-zA-Z]{3})*$/')));          
        
    // begin fix for the evil unique-with-multiple-nulls bug in Trac #41
    $this->validatorSchema['alt_id']->setOption('empty_value', null);
    
    $v1_base = new sfValidatorChoice(
      array('choices' => array(null), 'required' => false)
    );
    $v1 = new sfValidatorSchemaFilter('alt_id', $v1_base);
    
    $v2 = new sfValidatorPropelUnique(
      array('model' => 'EResource', 'column' => array('alt_id'))
    );
    
    $this->validatorSchema->setPostValidator(
      new sfValidatorOr(array($v1, $v2))
    );
    // end fix for #41

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema); 
    $this->widgetSchema->addFormFormatter('div', $decorator); 
    $this->widgetSchema->setFormFormatterName('div');  
  }
  
  public function save($con = null)
  {
    $object = parent::save();
    $this->saveAcqLibAssocList();
    
    return $object;
  }  

  protected function saveAcqLibAssocList()
  {
    // this list within the embedded Acquisition form;
    // see FreERMS Trac ticket 11
    
    $acquisition_object = $this->getObject()->getAcquisition();

    $er_values = $this->getValues();
    $lib_assoc_values = $er_values['Acquisition']['acq_lib_assoc_list'];
    
    $c = new Criteria();
    $c->add(AcqLibAssocPeer::ACQ_ID, $acquisition_object->getPrimaryKey());
    AcqLibAssocPeer::doDelete($c);

    if (is_array($lib_assoc_values))
    {
      foreach ($lib_assoc_values as $value)
      {
        $obj = new AcqLibAssoc();
        $obj->setAcqId($acquisition_object->getPrimaryKey());
        $obj->setLibId($value);
        $obj->save();
      }
    }
  }
}
