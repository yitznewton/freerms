<?php

class ReportGraphHostWidget extends sfWidgetFormChoice
{
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $hosts = Doctrine_Core::getTable('UrlUsage')->getAllHosts();

    // replace . with - in @id so jQuery/xui does not confuse with class selector
    $hosts = array_combine(
      array_map(function($a) {
        return str_replace('.', '-', $a);
      }, $hosts),
      $hosts
    );

    $options = array_merge($this->getOptions(), array(
      'add_empty' => false,
      'expanded' => true,
      'multiple' => true,
      'choices' => $hosts,
    ), $options);

    $this->setOptions($options);
  }
}

