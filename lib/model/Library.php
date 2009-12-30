<?php

class Library extends BaseLibrary
{
  public function __toString()
  {
    return $this->getName();
  }
}
