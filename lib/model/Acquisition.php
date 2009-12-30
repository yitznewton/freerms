<?php

class Acquisition extends BaseAcquisition
{
  public function __toString()
  {
    return $this->getNote();
  }
}
