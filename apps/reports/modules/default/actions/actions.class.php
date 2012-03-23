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

    $this->startFilter = new sfWidgetFormDate(array(
      'format' => '%year% &ndash; %month%',
      'years' => range(2008, date('Y')),
    ));

    $this->endFilter = new sfWidgetFormDate(array(
      'format' => '%year% &ndash; %month%',
      'years' => range(2008, date('Y')),
    ));

    $this->statistics = Doctrine_Core::getTable('DatabaseUsage')
      ->getStatisticsForDatabase($id);
  }
}

