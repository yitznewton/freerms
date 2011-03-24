<?php

/**
 * EResourceDbSubjectAssoc form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EResourceDbSubjectAssocForm extends BaseEResourceDbSubjectAssocForm
{
  public function configure()
  {
    $this->widgetSchema['featured_weight']->setLabel(
      'Weight for ' . $this->getObject()->getEResource()->getTitle() );
    
    $this->widgetSchema->setAttribute('class', 'EResourceDbSubjectAssocForm');
  }
}
