<?php

require_once dirname(__FILE__).'/../lib/ip_rangeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ip_rangeGeneratorHelper.class.php';

/**
 * ip_range actions.
 *
 * @package    freerms
 * @subpackage ip_range
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ip_rangeActions extends autoIp_rangeActions
{
  protected function addSortQuery($query)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc')))
    {
      $sort[1] = 'asc';
    }

    if (substr($sort[0], -3) == '_ip') {
      $sort[0] .= '_sort';
    }

    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }
}
