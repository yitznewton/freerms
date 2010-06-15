<?php

class freermsWidgetFormInputDisplay extends sfWidgetFormInput
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('indicator');
    $this->addOption('text');    
  }

  protected function renderDisplay()
  {
    $html = $this->renderContentTag(
      'span', $this->getOption('indicator') . ': ' . $this->getOption('text'),
      array( 'class' => 'input-display' )
    );    
    
    return $html;   
  }

 public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $baseAttributes = array(
      'type' => $this->getOption('type'),
      'name' => $name,
      'value' => $value
    );

   return $this->renderTag('input', array_merge($baseAttributes, $attributes))
     . "\n" . $this->renderDisplay() ;
  
  }
}
