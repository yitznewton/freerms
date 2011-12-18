<?php

namespace Yitznewton\FreermsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;

class IpRange
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $start_ip
     *
     * @Constraints\NotNull
     * @Constraints\Ip
     */
    protected $start_ip;

    /**
     * @var string $end_ip
     *
     * @Constraints\NotNull
     * @Constraints\Ip
     */
    protected $end_ip;

    /**
     * @var string $start_ip_sort
     */
    protected $start_ip_sort;

    /**
     * @var integer $end_ip_sort
     */
    protected $end_ip_sort;

    /**
     * @var boolean $is_active
     */
    protected $is_active;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startIp
     *
     * @param string $startIp
     */
    public function setStartIp($startIp)
    {
        if (!@ip2long($startIp)) {
            throw new \InvalidArgumentException("Invalid IP $startIp");
        }

        $this->startIpSort = IpRange::createSortString($startIp);
        $this->startIp     = $startIp;
    }

    /**
     * Get startIp
     *
     * @return string 
     */
    public function getStartIp()
    {
        return $this->startIp;
    }

    /**
     * Set endIp
     *
     * @param string $endIp
     */
    public function setEndIp($endIp)
    {
        if (!@ip2long($endIp)) {
            throw new \InvalidArgumentException("Invalid IP $endIp");
        }

        $this->endIpSort = IpRange::createSortString($endIp);
        $this->endIp     = $endIp;
    }

    /**
     * Get endIp
     *
     * @return string 
     */
    public function getEndIp()
    {
        return $this->endIp;
    }

    /**
     * needs to be public for Doctrine lifecycle events
     */
    public function setEndIpForSingle()
    {
        if (isset($this->startIp) && !isset($this->endIp)) {
            $this->setEndIp($this->startIp);
        }
    }

    /**
     * @param string $ip
     * @returns string
     */
    protected static function createSortString($ip)
    {
        $segments = array_map(function($v) {
            return sprintf('%03d', $v);
        }, explode('.', $ip));

        return implode('', $segments);
    }
}

