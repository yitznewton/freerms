<?php

class defaultActions extends sfActions
{
 /**
  * @param sfRequest $request A request object
  */
  public function executeDatabase(sfWebRequest $request)
  {
    $this->forward404Unless($id = $request->getParameter('id'));

    $this->reportMonths = array(
      '2011-01',
    );

    $this->filter = new DatabaseUsageFormFilter();
    $this->filter->getWidgetSchema()->setNameFormat('%s');

    $this->filter->bind($request->getGetParameters());

    $this->statistics = Doctrine_Core::getTable('DatabaseUsage')
      ->getStatisticsForDatabase($id);
  }
}

