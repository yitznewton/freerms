<?php

class ReportGraphWidget extends sfWidgetFormDoctrineChoice
{
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $options = array_merge($this->getOptions(), array(
      'add_empty' => false,
      'expanded' => true,
      'multiple' => true,
      'method' => 'toStringForWidget',
    ), $options);

    $this->setOptions($options);
  }
}

