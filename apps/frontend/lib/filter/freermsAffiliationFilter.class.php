<?php
/**
 * FreERMS
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to yitznewton@hotmail.com so we can send you a copy immediately.
 *
 * @version x
 * @package filter
 */
/**
 * freermsAffiliationFilter detects and takes actions based on user's
 * affilation
 *
 * @package filter
 * @copyright  Copyright (c) 2011 Benjamin Schaffer (http://yitznewton.org/)
 */
class freermsAffiliationFilter extends sfFilter
{
  public function execute($filterChain)
  {
    if ($this->isFirstCall()) {
      $this->context->setAffiliation(
        new freermsUserAffiliation(
          $this->context->getUser(), $this->context->getRequest()));
    }
    
    $filterChain->execute();
  }
}

