<?php

class IpRegMethod extends BaseIpRegMethod
{
  public function __toString()
  {
    return $this->getLabel();
  }
}
