<?php

class databaseActions extends sfActions
{
 /**
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($id = $request->getParameter('id'));

    $this->reportMonths = array(
      '2011-01',
      '2011-02',
      '2011-03',
      '2011-04',
      '2011-05',
      '2011-06',
      '2011-07',
      '2011-08',
      '2011-09',
      '2011-10',
      '2011-11',
      '2011-12',
      '2012-01',
      '2012-02',
      '2012-03',
      '2012-04',
      '2012-05',
      '2012-06',
      '2012-07',
      '2012-08',
      '2012-09',
      '2012-10',
      '2012-11',
      '2012-12',
    );

    $this->statistics = Doctrine_Core::getTable('DatabaseUsage')
      ->getStatisticsForDatabase($id);
  }
}

