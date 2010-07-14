<?php

class freermsWidgetFormInputDeleteAdd2 extends freermsWidgetFormInputLinks
{
  protected $objects = array();
  protected $index;

  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption( 'add_attributes', array() );
    $this->addOption( 'add_text', 'Add' );
    $this->addOption( 'add_action' );
    $this->addOption( 'delete_attributes', array() );
    $this->addOption( 'delete_text', 'Delete' );
    $this->addOption( 'delete_action' );
  }

  public function setObjects( array $objects )
  {
    $this->objects = $objects;
  }
  
  public function setIndex( $index )
  {
    if ( ! is_int( $index ) ) {
      throw new InvalidArgumentException( 'Argument must be an integer' );
    }
    
    $this->index = $index;
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

  protected function renderLinks()
  {
    if ( $this->index === null || ! $this->objects ) {
      throw new Exception('index or objects not set');
    }
    
    $controller = sfContext::getInstance()->getController();

    if ( $this->getOption('delete_action') ) {
      $route = $controller->genUrl( $this->getOption('delete_action') )
               .'?id=' . $this->objects[$this->index]->getId();

      $this->options['delete_attributes']['href'] = $route;
    }
    else {
      $this->options['delete_attributes']['href'] = '#';
    }

    if ( $this->getOption('add_action') ) {
      $route = $controller->genUrl( $this->getOption('add_action') )
               .'?id=' . $this->objects[$this->index]->getId();

      $this->options['add_attributes']['href'] = $route;
    }
    else {
      $this->options['add_attributes']['href'] = '#';
    }

    if ( count( $this->objects ) > 1 ) {
      $this->addLink( array(
        'text' => $this->getOption('delete_text'),
        'attributes' => $this->getOption('delete_attributes'),
      ) );
    }

    if (
      $this->index === (count( $this->objects ) - 1)
      && ! $this->objects[$this->index]->isNew()
    ) {
      $this->addLink( array(
        'text' => $this->getOption('add_text'),
        'attributes' => $this->getOption('add_attributes'),
      ) );
    }

    return parent::renderLinks();
  }
}
