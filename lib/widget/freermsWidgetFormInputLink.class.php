<?php

class freermsWidgetFormInputLink extends sfWidgetFormInput
{
  public function setLinkText($text)
  {
    $this->setOption('linkText', htmlspecialchars($text));
  }
  
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    
    $this->addOption('url');
    $this->addOption('linkText');
    $this->addOption('target');
    
    // default - overridden at instantiation if specified
    $this->setOption('linkText', 'Go');
  }
  
  protected function renderLink($url)
  {
    if ( !is_string($url) || strlen($url) < 1 ) {
      throw new Exception('URL must be a non-empty string');
    }
    
    $a_attributes = array('href' => $url, 'class' => 'input-link');
    
    if ($this->getOption('target')) {
      $a_attributes['target'] = $this->getOption('target');
    }
    
    $html = $this->renderContentTag(
      'a', $this->getOption('linkText'), $a_attributes
    );

    return $this->renderContentTag( 'span', $html, array( 'class' => 'input-links' ) );
  }  
   
  public function render(
    $name, $value = null, $attributes = array(), $errors = array())
  {
    $baseAttributes = array(
      'name'  => $name,
      'type'  => 'text',
      'value' => $value,     
    );  
      
    return $this->renderTag('input', array_merge($baseAttributes, $attributes))
      . "\n" . $this->renderLink($this->getOption('url'));
  }
  
}
  
 

