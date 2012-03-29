<?php

abstract class ReportSqlQuery
{
  /**
   * @param string $string
   */
  protected function sanitize($string)
  {
    return preg_replace('/[^A-Za-z0-9_]/', '', $string);
  }
}

