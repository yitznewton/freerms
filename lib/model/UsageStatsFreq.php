<?php

class UsageStatsFreq extends BaseUsageStatsFreq
{
  public function __toString()
  {
    return $this->getLabel();
  }
}
