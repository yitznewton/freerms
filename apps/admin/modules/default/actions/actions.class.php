<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * defaultActions module.
 *
 * @package    symfony
 * @subpackage action
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 4555 2007-07-08 14:55:07Z fabien $
 */
class defaultActions extends sfActions
{
  /**
   * Error page for page not found (404) error
   *
   */
  public function executeError404()
  {
  }

  public function executeError500()
  {
    $this->getResponse()->setHTTPHeader('HTTP/1.0 500 Internal Server Error', 500);
  }
  
  /**
   * Warning page for restricted area - requires login
   *
   */
  public function executeSecure()
  {
  }

  /**
   * Module disabled in settings.yml
   *
   */
  public function executeDisabled()
  {
  }
}
