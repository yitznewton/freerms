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

    $this->reportMonths = $this->getReportMonths($values);

    $this->statistics = Doctrine_Core::getTable('DatabaseUsage')
      ->getStatisticsForDatabase($id, $values);
  }

  /**
   * @param array $values
   * @return array string[]
   */
  protected function getReportMonths(array $values)
  {
    // default: one-year period ending with last month
    $from = isset($values['timestamp']['from'])
      ? $values['timestamp']['from']
      : date('Y-m', time() - 60*60*24*392);

    $to = isset($values['timestamp']['to'])
      ? $values['timestamp']['to']
      : date('Y-m', time() - 60*60*24*27);

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

