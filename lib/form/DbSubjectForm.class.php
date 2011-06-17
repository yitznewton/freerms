<?php

/**
 * DbSubject form.
 *
 * @package    freerms
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class DbSubjectForm extends BaseDbSubjectForm
{
  public function configure()
  {
    unset(
      $this['e_resource_db_subject_assoc_list']
    );

    $decorator = new freermsWidgetFormatterDiv($this->widgetSchema);
    $this->widgetSchema->addFormFormatter('div', $decorator);
    $this->widgetSchema->setFormFormatterName('div');

    $er_container_form = new sfForm();

    $c = new Criteria();
    $c->addAscendingOrderByColumn( EResourcePeer::SORT_TITLE );
    
    foreach ( $this->getObject()->getEResourceDbSubjectAssocs( $c ) as $esa ) {
      $form = new EResourceDbSubjectAssocForm( $esa );
      $er_container_form->embedForm( $esa->getErId(), $form );
    }

    $this->embedForm( 'EResourceDbSubjectAssocs', $er_container_form );
  }
}
