<?php

class AuthMethod extends BaseAuthMethod
{
  public function __toString()
  {
    return $this->getLabel();
  }
}
