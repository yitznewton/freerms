<?php

namespace Yitznewton\FreermsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yitznewton\FreermsBundle\Entity\IpRange
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Yitznewton\FreermsBundle\Entity\IpRangeRepository")
 */
class IpRange
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $StartIp
     *
     * @ORM\Column(name="StartIp", type="string", length=15)
     */
    private $StartIp;

    /**
     * @var string $EndIp
     *
     * @ORM\Column(name="EndIp", type="string", length=15)
     */
    private $EndIp;

    /**
     * @var integer $StartIpInt
     *
     * @ORM\Column(name="StartIpInt", type="integer")
     */
    private $StartIpInt;

    /**
     * @var integer $EndIpInt
     *
     * @ORM\Column(name="EndIpInt", type="integer")
     */
    private $EndIpInt;


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
     * Set StartIp
     *
     * @param string $startIp
     * @return IpRange
     */
    public function setStartIp($startIp)
    {
        $this->StartIp = $startIp;
        return $this;
    }

    /**
     * Get StartIp
     *
     * @return string 
     */
    public function getStartIp()
    {
        return $this->StartIp;
    }

    /**
     * Set EndIp
     *
     * @param string $endIp
     * @return IpRange
     */
    public function setEndIp($endIp)
    {
        $this->EndIp = $endIp;
        return $this;
    }

    /**
     * Get EndIp
     *
     * @return string 
     */
    public function getEndIp()
    {
        return $this->EndIp;
    }

    /**
     * Set StartIpInt
     *
     * @param integer $startIpInt
     * @return IpRange
     */
    public function setStartIpInt($startIpInt)
    {
        $this->StartIpInt = $startIpInt;
        return $this;
    }

    /**
     * Get StartIpInt
     *
     * @return integer 
     */
    public function getStartIpInt()
    {
        return $this->StartIpInt;
    }

    /**
     * Set EndIpInt
     *
     * @param integer $endIpInt
     * @return IpRange
     */
    public function setEndIpInt($endIpInt)
    {
        $this->EndIpInt = $endIpInt;
        return $this;
    }

    /**
     * Get EndIpInt
     *
     * @return integer 
     */
    public function getEndIpInt()
    {
        return $this->EndIpInt;
    }
}