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
    protected $is_active = true;

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

        $this->start_ip_sort = IpRange::createSortString($startIp);
        $this->start_ip      = $startIp;
    }

    /**
     * Get startIp
     *
     * @return string 
     */
    public function getStartIp()
    {
        return $this->start_ip;
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

        $this->end_ip_sort = IpRange::createSortString($endIp);
        $this->end_ip      = $endIp;
    }

    /**
     * Get endIp
     *
     * @return string 
     */
    public function getEndIp()
    {
        return $this->end_ip;
    }

    /**
     * needs to be public for Doctrine lifecycle events
     */
    public function setEndIpForSingle()
    {
        if (isset($this->start_ip) && !isset($this->end_ip)) {
            $this->setEndIp($this->start_ip);
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

    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @return string
     */
    public function getStartIpSort()
    {
        return $this->start_ip_sort;
    }

    /**
     * @return string
     */
    public function getEndIpSort()
    {
        return $this->end_ip_sort;
    }
}

