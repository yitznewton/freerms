<?php

class UsageStatsFormat extends BaseUsageStatsFormat
{
  public function __toString()
  {
    return $this->getLabel();
  }
}
