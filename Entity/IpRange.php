<?php

namespace Yitznewton\FreermsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;

/**
 * Yitznewton\FreermsBundle\Entity\IpRange
 *
 * @ORM\Table(name="ip_range")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class IpRange
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $start_ip
     *
     * @ORM\Column(name="start_ip",type="string",length=15,nullable=false)
     *
     * @Constraints\NotNull
     * @Constraints\Ip
     */
    protected $startIp;

    /**
     * @var string $end_ip
     *
     * @ORM\Column(name="end_ip",type="string",length=15,nullable=false)
     *
     * @Constraints\NotNull
     * @Constraints\Ip
     */
    protected $endIp;

    /**
     * @var string $start_ip_sort
     *
     * @ORM\Column(name="start_ip_sort",type="string",length=12,nullable=false)
     */
    protected $startIpSort;

    /**
     * @var integer $end_ip_sort
     *
     * @ORM\Column(name="end_ip_sort",type="string",length=12,nullable=false)
     */
    protected $endIpSort;

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
     * @ORM\PrePersist
     * @ORM\PreUpdate
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
