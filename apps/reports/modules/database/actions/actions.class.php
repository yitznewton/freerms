<?php

class databaseActions extends sfActions
{
 /**
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($id = $request->getParameter('id'));

    $this->statistics = Doctrine_Core::getTable('DatabaseUsage')
      ->getStatisticsForDatabase($id);
    var_dump($this->statistics);
  }
}
