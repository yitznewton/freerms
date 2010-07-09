<?php

class freermsWidgetFormInputDeleteAdd extends sfWidgetFormInput
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('model_id');
    $this->addOption('confirm');
    $this->addOption('delete_action');
    $this->addOption('delete_text', null);
    $this->addOption('add_action');
    $this->addOption('add_text', null);
  }

  protected function renderLink()
  {
    $html_bits = array();   

    $delete_text = $this->getOption('delete_text');

    $controller = sfContext::getInstance()->getController();
    $delete_action = $controller->genUrl($this->getOption('delete_action'))
      .'?id='.$this->getOption('model_id');

    $add_text = $this->getOption('add_text');
    
    $add_action = $this->getOption('add_action');      

    $a_attributes_delete = array(
      'href' => $delete_action,
      'class' => 'input-link',
      'onclick' => 'if (confirm(\''.$this->getOption('confirm').'\')) { return true; };return false;',
    );

    $a_attributes_add = array(
      'href' => '#',
      'class' => 'input-link',
      'onclick' => 'return '. $add_action,
    );
     
    $html_bits[0] = $this->renderContentTag( 'a', $delete_text, $a_attributes_delete );

    $html_bits[1] = $this->renderContentTag( 'a', $add_text, $a_attributes_add );

    if (!is_null($delete_text) && !is_null($add_text)){
      $html = implode( ' | ', $html_bits );
    }
    else {
      $html = implode(' ', $html_bits);
    }
        
    return $html;    
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
     $baseAttributes = array(
      'name'  => $name,
      'type'  => 'text',
      'value' => $value,
    );

    return $this->renderTag('input', array_merge($baseAttributes, $attributes))
      . "\n" . $this->renderLink();   
  }
}
