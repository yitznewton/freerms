<?php

class freermsWidgetFormSelectCheckboxLink extends sfWidgetFormSelectCheckbox
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

  protected function formatChoices($name, $value, $choices, $attributes)
  {
    if (!$choices) {
      return $this->formatter($this, array());
    }

    $inputs = array();
    foreach ($choices as $key => $option)
    {
      $baseAttributes = array(
        'name'  => $name,
        'type'  => 'checkbox',
        'value' => self::escapeOnce($key),
        'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
      );

      if ((is_array($value) && in_array(strval($key), $value))
        || strval($key) == strval($value)
      ) {
        $baseAttributes['checked'] = 'checked';
      }
      
      $input_span = $this->renderContentTag('span',
        $this->renderTag('input', array_merge($baseAttributes, $attributes))
        ."\n".$this->renderContentTag('label', $option, array('for' => $id))
      );

      $a = $this->renderContentTag(
             'a',
             $this->getOption('linkText'),
             array( 'href' => $this->getOption('url') . $key,
                    'class' => 'input-link')
           ) . "\n";
      
      $elements[] = array(
        'span' => $input_span."\n",
        'link' => $a,
      );
    }

    return $this->formatter($this, $elements);
  }

  public function formatter($widget, $elements)
  {
    $rows = array();

    foreach ($elements as $element)
    {
      $link_span = $this->renderContentTag(
        'span', $element['link'], array('class'=>'input-links')
      );

      $rows[] = $this->renderContentTag(
        'li',
        $element['span'].' '.$link_span
      )."\n";
    }

    return $this->renderContentTag(
      'ul',
      implode($this->getOption('separator'), $rows),
      array('class' => $this->getOption('class'))
    )."\n";
  }
}
