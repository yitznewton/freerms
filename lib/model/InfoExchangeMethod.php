<?php

class InfoExchangeMethod extends BaseInfoExchangeMethod
{
  public function __toString()
  {
    return $this->getLabel();
  }
}
