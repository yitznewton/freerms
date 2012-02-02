<?php

class freermsTemplateFilter extends sfFilter
{
  public function execute($filterChain)
  {
    // observer effect: calling isFirstCall() means that it will be false
    // the next time called

    if ($this->isFirstCall()) {
      if ($this->context->getUser()->hasAttribute('template')) {
        $this->setTemplate($this->context->getUser()
          ->getAttribute('template'));
      }
      elseif ($template = $this->getTemplateFromRequest()) {
        $this->context->getUser()->setAttribute('template', $template);
        $this->setTemplate($template);
      }
    }

    $filterChain->execute();
  }

  /**
   * @return string
   */
  protected function getTemplateFromRequest()
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
   * Sets decorator template, ignores if it does not exist
   *
   * @param string $template
   */
  protected function setTemplate($template)
  {
    if (ProjectConfiguration::getActive()->getDecoratorDir($template.'.php')) {
      $this->context->getActionStack()->getLastEntry()
        ->getActionInstance()->setLayout($template);
    }
  }
}

