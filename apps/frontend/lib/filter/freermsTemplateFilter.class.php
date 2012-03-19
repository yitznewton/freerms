<?php

class freermsTemplateFilter extends sfFilter
{
  public function execute($filterChain)
  {
    // observer effect: calling isFirstCall() means that it will be false
    // the next time called

    if ($this->isFirstCall()) {
      $layout = $this->getLayout();

      if ($this->layoutExists($layout.'_mobile') && $this->isMobile()) {
        $this->setLayout($layout.'_mobile');
      }
      elseif ($this->layoutExists($layout)) {
        $this->setLayout($layout);
      }
    }

    $filterChain->execute();
  }

  protected function getLayout()
  {
    $fromRequest = $this->getLayoutFromRequest();
    $fromUser = $this->context->getUser()->getAttribute('template', null);

    if ($this->layoutExists($fromRequest)) {
      return preg_replace('/_mobile$/', '', $fromRequest);
    }
    elseif ($this->layoutExists($fromUser)) {
      return preg_replace('/_mobile$/', '', $fromUser);
    }
    else {
      return 'layout';
    }
  }

  /**
   * @param string $template
   */
  protected function setLayout($template)
  {
    $this->context->getUser()->setAttribute('template', $template);

    $this->context->getActionStack()->getLastEntry()
      ->getActionInstance()->setLayout($template);
  }

  /**
   * @return string
   */
  protected function getLayoutFromRequest()
  {
    $request = $this->context->getRequest();

    if ($request->hasParameter('layout')) {
      return $request->getParameter('layout');
    }
    elseif ($request->hasParameter('site')) {
      return $request->getParameter('site');
    }

    $host = $request->getHost();

    if (strpos($host, '.') !== false) {
      $host = substr($host, 0, strpos($host, '.'));
    }

    if ($host) {
      return $host;
    }

    return null;
  }

  /**
   * @return bool
   */
  protected function layoutExists($template)
  {
    return (bool) ProjectConfiguration::getActive()
      ->getDecoratorDir($template.'.php');
  }

  /**
   * @return book
   */
  protected function isMobile()
  {
    $request = $this->context->getRequest();

    if ($request->hasParameter('force-no-mobile') && $request->isMobile()) {
      $isMobile = !$request->getParameter('force-no-mobile');
      $this->context->getUser()->setAttribute('is_mobile', $isMobile);

      return $isMobile; 
    }

    if ($this->context->getUser()->getAttribute('is_mobile') === false) {
      return false;
    }

    $this->context->getUser()->setAttribute('is_mobile', $request->isMobile());

    return $request->isMobile();
  }
}

