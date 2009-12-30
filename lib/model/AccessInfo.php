<?php

class AccessInfo extends BaseAccessInfo
{
  public function __toString()
  {
    return $this->getOnsiteAccessUri();
  }
}
