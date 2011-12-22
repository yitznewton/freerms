<?php

class freermsValidatorDatabaseSortTitle extends sfValidatorBase
{
  protected function doClean($values)
  {
    if (empty($values['sort_title'])) {
      $values['sort_title'] = $values['title'];
    }

    return $values;
  }
}

