<?php

class freermsWidgetFormInputLinks extends sfWidgetFormInput
{
  protected $links = array();

  public function addLink( array $link, $key = null )
  {
    if ( $key ) {
      $this->links[$key] = $link;
    }
    else {
      $this->links[] = $link;
    }
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
      . "\n" . $this->renderLinks();
  }

  protected function renderLinks()
  {
    $html_spans = array();

    foreach ( $this->links as $link ) {
      if ( ! isset( $link['attributes'] ) || ! isset( $link['text'] ) ) {
        continue;
      }

      $html_a = $this->renderContentTag(
        'a', $link['text'], $link['attributes']
      );

      $html_spans[] = $this->renderContentTag(
        'span', $html_a, array( 'class' => 'input-links' )
      );
    }

    return implode( ' | ', $html_spans );
  }
}
