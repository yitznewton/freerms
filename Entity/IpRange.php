<?php

namespace Yitznewton\FreermsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yitznewton\FreermsBundle\Entity\IpRange
 *
 * @ORM\Table(name="ip_range")
 * @ORM\Entity
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
     * @ORM\Column(name="start_ip",type="string", length=15)
     */
    protected $startIp;

    /**
     * @var string $end_ip
     *
     * @ORM\Column(name="end_ip",type="string", length=15)
     */
    protected $endIp;

    /**
     * @var integer $start_ip_int
     *
     * @ORM\Column(name="start_ip_int",type="integer")
     */
    protected $startIpInt;

    /**
     * @var integer $end_ip_int
     *
     * @ORM\Column(name="end_ip_int",type="integer")
     */
    protected $endIpInt;

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
        $this->startIp = $startIp;
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
        $this->endIp = $endIp;
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
     * Set startIpInt
     *
     * @param integer $startIpInt
     */
    public function setStartIpInt($startIpInt)
    {
        $this->startIpInt = $startIpInt;
    }

    /**
     * Get startIpInt
     *
     * @return integer 
     */
    public function getStartIpInt()
    {
        return $this->startIpInt;
    }

    /**
     * Set endIpInt
     *
     * @param integer $endIpInt
     */
    public function setEndIpInt($endIpInt)
    {
        $this->endIpInt = $endIpInt;
    }

    /**
     * Get endIpInt
     *
     * @return integer 
     */
    public function getEndIpInt()
    {
        return $this->endIpInt;
    }
}

