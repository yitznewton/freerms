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
 * @package user
 */
/**
 * freermsUserInterface specifies the interface for all user classes to be
 * used in FreERMS
 *
 * @package user
 * @copyright  Copyright (c) 2011 Benjamin Schaffer (http://yitznewton.org/)
 */
interface freermsUserInterface
{
  /**
   * @return array int[]
   */
  public function getLibraryIds();
  /**
   * @return string
   */
  public function getUsername();
}
