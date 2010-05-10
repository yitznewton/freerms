<?php

class freermsWidgetFormChoiceLink extends sfWidgetFormChoice
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('link_urls');   
    $this->addOption('target');
  }

  protected function renderLink($link_urls)
  {
    $html_bits = array();
    
    foreach ($link_urls as $linkText => $url){
      
      if ( ! $url || ! is_string( $url ) ){
        $msg = 'Each URL must be a non-empty string';
        throw new InvalidArgumentException( $msg );
      }

      $a_attributes = array('href' => $url, 'class' => 'input-link');

      if ($this->getOption('target')) {
        $a_attributes['target'] = $this->getOption('target');
      }

      $html_bits[] = $this->renderContentTag( 'a', $linkText, $a_attributes );
    }

    $html = implode( ' | ', $html_bits );
    
    return $this->renderContentTag( 'span', $html, array( 'class' => 'input-links' ) );
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ($this->getOption('multiple'))
    {
      $attributes['multiple'] = 'multiple';

      if ('[]' != substr($name, -2))
      {
        $name .= '[]';
      }
    }

    if (!$this->getOption('renderer') && !$this->getOption('renderer_class') && $this->getOption('expanded'))
    {
      unset($attributes['multiple']);
    }

    return $this->getRenderer()->render($name, $value, $attributes, $errors)
      . "\n" . $this->renderLink($this->getOption('link_urls'));
  }
}
