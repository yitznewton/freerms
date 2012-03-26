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
      : date('Y-m', time() - 60*60*24*365);

    $values['timestamp']['to'] = isset($values['timestamp']['to'])
      ? $values['timestamp']['to']
      : date('Y-m', time() - 60*60*24*27);

    $this->reportMonths = $this->getReportMonths(
      $values['timestamp']['from'],
      $values['timestamp']['to']);

    $table = Doctrine_Core::getTable('DatabaseUsage');

    $this->statistics  = $table->getStatisticsForDatabase($id, $values);
    $this->mobileShare = $table->getShareForDatabase($id, 'is_mobile', $values);
    $this->onsiteShare = $table->getShareForDatabase($id, 'is_onsite', $values);
  }

  /**
   * @param string $from
   * @param string $to
   * @return array string[]
   */
  protected function getReportMonths($from, $to)
  {
    $from = array(
      'year' => substr($from, 0, 4),
      'month' => substr($from, -2),
    );

    $to = array(
      'year' => substr($to, 0, 4),
      'month' => substr($to, -2),
    );

    if ($from['year'] === $to['year']) {
      return $this->getMonths($from['year'], $from['month'], $to['month']);
    }

    $monthsFirstYear = $this->getMonths(
      $from['year'], $from['month'], 12
    );

    $monthsLastYear = $this->getMonths(
      $to['year'], 1, $to['month']
    );

    $monthsMiddleYears = array();

    for ($i = $from['year'] + 1; $i < $to['year']; $i++) {
      $monthsMiddleYears = array_merge($monthsMiddleYears,
        $this->getMonths($i, 1, 12));
    }

    return array_merge($monthsFirstYear, $monthsMiddleYears, $monthsLastYear);
  }

  /**
   * @param int $year
   * @param int $startMonth
   * @param int $endMonth
   */
  protected function getMonths($year, $startMonth, $endMonth)
  {
    $months = array();

    for ($i = $startMonth; $i < $endMonth + 1; $i++) {
      $months[] = $year . '-' . sprintf('%02d', $i);
    }

    return $months;
  }
}

