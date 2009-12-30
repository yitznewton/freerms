<?php

class GeneralStatus extends BaseGeneralStatus
{
  public function __toString()
  {
    return $this->getLabel();
  }
}
