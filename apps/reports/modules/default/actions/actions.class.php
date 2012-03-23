<?php

class defaultActions extends sfActions
{
 /**
  * @param sfRequest $request A request object
  */
  public function executeDatabase(sfWebRequest $request)
  {
    $this->forward404Unless($id = $request->getParameter('id'));

    $this->filter = new DatabaseUsageFormFilter();
    $this->filter->getWidgetSchema()->setNameFormat('%s');

    $this->filter->bind($request->getGetParameters());

    if ($this->filter->isValid()) {
      $values = $this->filter->getValues();
    }
    else {
      $values = array();
    }

    // default: one-year period ending with last month
    $values['timestamp']['from'] = isset($values['timestamp']['from'])
      ? $values['timestamp']['from']
      : date('Y-m', time() - 60*60*24*392);

    $values['timestamp']['to'] = isset($values['timestamp']['to'])
      ? $values['timestamp']['to']
      : date('Y-m', time() - 60*60*24*27);

    $this->reportMonths = $this->getReportMonths(
      $values['timestamp']['from'],
      $values['timestamp']['to']);

    $this->statistics = Doctrine_Core::getTable('DatabaseUsage')
      ->getStatisticsForDatabase($id, $values);
  }

  /**
   * @param string $from
   * @param string $to
   * @return array string[]
   */
  protected function getReportMonths($from, $to)
  {
    $months = array();

    for ($i = (int) substr($from, -2); $i < 13; $i++) {
      $months[] = substr($from, 0, 4) . '-' . sprintf('%02d', $i);
    }

    for ($i = ((int) substr($from, 0, 4)) + 1; $i < (int) substr($to, 0, 4); $i++) {
      for ($j = 1; $j < 13; $j++) {
        $months[] = $i . '-' . sprintf('%02d', $j);
      }
    }

    for ($i = 1; $i <= (int) substr($to, -2); $i++) {
      $months[] = substr($to, 0, 4) . '-' . sprintf('%02d', $i);
    }

    return $months;
  }
}

