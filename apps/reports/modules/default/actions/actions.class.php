<?php

class defaultActions extends sfActions
{
  public function preExecute()
  {
    $this->filter = new DatabaseUsageFormFilter();
    $this->filter->getWidgetSchema()->setNameFormat('%s');

    $this->filter->bind($this->getRequest()->getGetParameters());

    if ($this->filter->isValid()) {
      $this->filterValues = $this->filter->getValues();
    }
    else {
      $this->filterValues = array();
    }

    // default: one-year period ending with last month
    $this->filterValues['timestamp']['from']
      = isset($this->filterValues['timestamp']['from'])
        ? $this->filterValues['timestamp']['from']
        : date('Y-m', time() - 60*60*24*365);

    $this->filterValues['timestamp']['to']
      = isset($this->filterValues['timestamp']['to'])
        ? $this->filterValues['timestamp']['to']
        : date('Y-m', time() - 60*60*24*27);

    $this->reportMonths = $this->getReportMonths(
      $this->filterValues['timestamp']['from'],
      $this->filterValues['timestamp']['to']);
  }

  /**
   * @param sfRequest $request A request object
   */
  public function executeDatabase(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless(Doctrine_Core::getTable('Database')->find($id));

    $table = Doctrine_Core::getTable('DatabaseUsage');

    $this->statistics = $table->getStatisticsForDatabase($id,
      $this->filterValues);

    $this->mobileShare = $table->getShareForDatabase($id, 'is_mobile',
      $this->filterValues);

    $this->onsiteShare = $table->getShareForDatabase($id, 'is_onsite',
      $this->filterValues);
  }

  /**
   * @param sfRequest $request A request object
   */
  public function executeLibrary(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless(Doctrine_Core::getTable('Library')->find($id));

    $table = Doctrine_Core::getTable('DatabaseUsage');

    $this->statistics = $table->getStatisticsForLibrary($id,
      $this->filterValues);

    $this->mobileShare = $table->getShareForLibrary($id, 'is_mobile',
      $this->filterValues);

    $this->onsiteShare = $table->getShareForLibrary($id, 'is_onsite',
      $this->filterValues);
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

