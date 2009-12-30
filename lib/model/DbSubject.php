<?php

class DbSubject extends BaseDbSubject
{
  public function __toString()
  {
    return $this->getLabel();
  }  
}
