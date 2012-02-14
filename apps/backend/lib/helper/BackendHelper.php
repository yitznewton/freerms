<?php

function backend_menu_item($sf_params, $label, $route, $module, $exclude_action = null)
{
  if ($sf_params->get('module') == $module && $sf_params->get('action') != $exclude_action) {
    $class = 'ui-state-active';
  }
  else {
    $class = 'ui-state-default';
  }
  
  if ($sf_params->get('module') == $module && $sf_params->get('action') == 'index') {
    $inner = $label;
  }
  else {
    $inner = link_to($label, $route);
  }

  return content_tag('li', $inner, array('class' => $class));
}

