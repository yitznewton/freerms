<?php

class freermsTemplateFilter extends sfFilter
{
  public function execute($filterChain)
  {
    // observer effect: calling isFirstCall() means that it will be false
    // the next time called

    if ($this->isFirstCall()) {
      $fromUser = $this->context->getUser()->getAttribute('template', null);
      $fromRequest = $this->getTemplateFromRequest();

      if ($this->templateExists($fromRequest.'_mobile') && $this->isMobile()) {
        $this->setTemplate($fromRequest.'_mobile');
      }
      elseif ($this->templateExists($fromRequest)) {
        $this->setTemplate($fromRequest);
      }
      elseif ($this->templateExists($fromUser)) {
        $this->setTemplate($fromUser);
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
   * @return bool
   */
  protected function templateExists($template)
  {
    return (bool) ProjectConfiguration::getActive()
      ->getDecoratorDir($template.'.php');
  }

  /**
   * @return book
   */
  protected function isMobile()
  {
    $browser_ptn = '/(android|blackberry|blazer|symbian|fennec|dorothy'
                   . '|gobrowser|nokia|ipad|iphone|ipod|iemobile|mib|minimo'
                   . '|opera mini|opera mobi|semc|skyfire|uzard)/i';

    return (bool) preg_match($browser_ptn,
      $this->context->getRequest()->getHTTPHeader('User-Agent'));
  }

  /**
   * @param string $template
   */
  protected function setTemplate($template)
  {
    $this->context->getUser()->setAttribute('template', $template);

    $this->context->getActionStack()->getLastEntry()
      ->getActionInstance()->setLayout($template);
  }
}

