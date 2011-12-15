<?php

namespace Yitznewton\FreermsBundle\Model;

use Yitznewton\FreermsBundle\Model\om\BaseIpRange;

class IpRange extends BaseIpRange {
    public function setStartIp($v)
    {
        if (!@ip2long($v)) {
            throw new \InvalidArgumentException("Invalid IP $v");
        }

        $this->setStartIpSort(IpRange::generateSortString($v));
        parent::setStartIp($v);
    }

    public function setEndIp($v)
    {
        if (!@ip2long($v)) {
            throw new \InvalidArgumentException("Invalid IP $v");
        }

        $this->setEndIpSort(IpRange::generateSortString($v));
        parent::setEndIp($v);
    }

    /**
     * @param \PropelPDO $con
     * @return boolean
     */
    public function preSave(\PropelPDO $con = null)
    {
        if ($this->getStartIp() && !$this->getEndIp()) {
            $this->setEndIp($this->getStartIp());
        }

        return true;
    }

    /**
     * @param string $ip
     * @returns string
     */
    protected static function generateSortString($ip)
    {
        $segments = array_map(function($v) {
            return sprintf('%03d', $v);
        }, explode('.', $ip));

        return implode('', $segments);
    }
}

