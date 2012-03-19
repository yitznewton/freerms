<?php
class frontendWebRequest extends sfWebRequest
{
  protected $isMobile;

  public function isMobile()
  {
    if (isset($this->isMobile)) {
      return $this->isMobile;
    }

    $browser_ptn = '/(android|blackberry|blazer|symbian|fennec|dorothy'
                   . '|gobrowser|nokia|ipad|iphone|ipod|iemobile|mib|minimo'
                   . '|opera mini|opera mobi|semc|skyfire|uzard)/i';

    return $this->isMobile = (bool) preg_match($browser_ptn,
      $this->getHTTPHeader('User-Agent'));
  }
}

