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


    if (!isset($this->filterValues['timestamp']['from'])) {
      $this->filterValues['timestamp']['from']
        = date('Y-m', time() - 60*60*24*365);
    }

    if (!isset($this->filterValues['timestamp']['to'])) {
      $this->filterValues['timestamp']['to']
        = date('Y-m', time() - 60*60*24*27);
    }

    $this->reportMonths = $this->getReportMonths(
      $this->filterValues['timestamp']['from'],
      $this->filterValues['timestamp']['to']);
  }

  /**
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->databases = Doctrine_Core::getTable('Database')->createQuery('d')
      ->orderBy('d.sort_title')
      ->execute()
      ;

    $this->libraries = Doctrine_Core::getTable('Library')->createQuery('l')
      ->orderBy('l.name')
      ->execute()
      ;

    $this->hosts = Doctrine_Core::getTable('UrlUsage')->getAllHosts();
  }

  /**
   * @param sfRequest $request A request object
   */
  public function executeDatabase(sfWebRequest $request)
  {
    $this->forward404Unless($by = $request->getParameter('by'));

    switch (strtolower($by)) {
      case 'database':
        $this->forward404Unless(
          $database = Doctrine_Core::getTable('Database')
          ->find($request->getParameter('filter')));
        $this->pageTitle = 'Usage for ' . $database->getTitle();

        $groupByColumn = 'library_id';
        $groupByModel = 'Library';
        $labelColumn = 'code';
        $labelModel = 'Library';
        $this->filterValues['database_id'] = $request->getParameter('filter');
        $this->graphFilterTitle = 'Library';
        $this->graphFilter = new ReportGraphWidget(array('model' => 'Library'));
        $this->tableLinkRoute = '@database_by_library?filter=%';
        break;

      case 'library':
        $this->forward404Unless(
          $library = Doctrine_Core::getTable('Library')
          ->find($request->getParameter('filter')));
        $this->pageTitle = 'Usage for ' . $library->getName();

        $groupByColumn = 'database_id';
        $groupByModel = 'Database';
        $labelColumn = 'title';
        $labelModel = 'Database';
        $this->filterValues['library_id'] = $request->getParameter('filter');
        $this->graphFilterTitle = 'Database';
        $this->graphFilter = new ReportGraphWidget(array(
          'model' => 'Database',
          'order_by' => array('sort_title', 'asc'),
          'method' => 'toStringForWidget',
        ));
        $this->tableLinkRoute = '@database_by_database?filter=%';
        break;

      default:
        $this->forward404();
    }

    $table = Doctrine_Core::getTable('DatabaseUsage');

    $statsQuery = new StatsSqlQuery(Doctrine_Core::getTable('DatabaseUsage'));
    $statsQuery->addFilters($this->filterValues);
    $statsQuery->setLabelColumn($labelColumn, $labelModel);
    $statsQuery->setGroupBy($groupByColumn, $groupByModel);

    $onsiteShareQuery = new ShareSqlQuery($table, 'is_onsite');
    $onsiteShareQuery->addFilters($this->filterValues);

    $mobileShareQuery = new ShareSqlQuery($table, 'is_mobile');
    $mobileShareQuery->addFilters($this->filterValues);

    $this->statistics = $statsQuery->get();

    $this->onsiteShare = $onsiteShareQuery->get();
    $this->mobileShare = $mobileShareQuery->get();
  }

  /**
   * @param sfRequest $request A request object
   */
  public function executeUrl(sfWebRequest $request)
  {
    $this->forward404Unless($by = $request->getParameter('by'));

    switch (strtolower($by)) {
      case 'host':
        $this->pageTitle = 'Usage for ' . $request->getParameter('filter');
        $groupByColumn = 'library_id';
        $groupByModel = 'Library';
        $labelColumn = 'code';
        $labelModel = 'Library';
        $this->filterValues['host'] = $request->getParameter('filter');
        $this->graphFilterTitle = 'Library';
        $this->graphFilter = new ReportGraphWidget(array('model' => 'Library'));
        break;

      case 'library':
        $this->forward404Unless(
          $library = Doctrine_Core::getTable('Library')
          ->find($request->getParameter('filter')));
        $this->pageTitle = 'Usage for ' . $library->getName();

        $groupByColumn = 'host';
        $groupByModel = null;
        $labelColumn = 'host';
        $labelModel = null;
        $this->filterValues['library_id'] = $request->getParameter('filter');
        $this->graphFilterTitle = 'Host';
        $this->graphFilter = new ReportGraphHostWidget();
        break;

      default:
        $this->forward404();
    }

    $table = Doctrine_Core::getTable('UrlUsage');

    $statsQuery = new StatsSqlQuery(Doctrine_Core::getTable('UrlUsage'));
    $statsQuery->addFilters($this->filterValues);
    $statsQuery->setGroupBy($groupByColumn, $groupByModel);
    $statsQuery->setLabelColumn($labelColumn, $labelModel);

    $onsiteShareQuery = new ShareSqlQuery($table, 'is_onsite');
    $onsiteShareQuery->addFilters($this->filterValues);

    $mobileShareQuery = new ShareSqlQuery($table, 'is_mobile');
    $mobileShareQuery->addFilters($this->filterValues);

    $this->statistics = $statsQuery->get();

    $this->onsiteShare = $onsiteShareQuery->get();
    $this->mobileShare = $mobileShareQuery->get();

    $this->setTemplate('database');
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

