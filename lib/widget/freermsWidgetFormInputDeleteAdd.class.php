<?php

class freermsWidgetFormInputDeleteAdd extends sfWidgetFormInput
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('model_id');
    $this->addOption('confirm');
    $this->addOption('delete_action');
    $this->addOption('delete_text');
    $this->addOption('add_action');
    $this->addOption('add_text');
  }

  protected function renderLinks()
  {
    $controller = sfContext::getInstance()->getController();
    $html_bits  = array();

    $delete_text   = $this->getOption('delete_text');
    $add_text   = $this->getOption('add_text');

    if ( $delete_text ) {
      $delete_action = $controller->genUrl($this->getOption('delete_action'))
                       .'?id='.$this->getOption('model_id');

      $a_attributes_delete = array(
        'href' => $delete_action,
        'class' => 'input-link',
        'onclick' => 'if (confirm(\''.$this->getOption('confirm').'\')) { return true; };return false;',
      );

      $html_bits[] = $this->renderContentTag( 'a', $delete_text, $a_attributes_delete );
    }

    if ( $add_text ) {
      $a_attributes_add = array(
        'href' => '#',
        'class' => 'input-link',
        'onclick' => 'return ' . $this->getOption('add_action'),
      );
      
      $html_bits[] = $this->renderContentTag( 'a', $add_text, $a_attributes_add );
    }
     

    return implode( ' | ', $html_bits );
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
     $baseAttributes = array(
      'name'  => $name,
      'type'  => 'text',
      'value' => $value,
    );

    return $this->renderTag('input', array_merge($baseAttributes, $attributes))
           . "\n" . $this->renderLinks();
  }
}
