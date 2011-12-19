<?php

namespace Yitznewton\FreermsBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Yitznewton\FreermsBundle\Entity\IpRange;

class IpRangeRepositoryIntegrationTest extends WebTestCase
{
    private $_em;

    protected function setup()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->_em = $kernel->getContainer()
            ->get('doctrine.orm.entity_manager');

        $this->_em->createQuery('DELETE FROM FreermsBundle:IpRange i')
            ->execute();

        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.100.1');
        $ipRange->setEndIp('192.168.199.255');

        $this->_em->persist($ipRange);
        $this->_em->flush();
    }

    protected function getRepository()
    {
        return $this->_em->getRepository('FreermsBundle:IpRange');
    }

    public function testFindIntersecting_RangeWithin_ReturnsIpRange()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.150.1');
        $ipRange->setEndIp('192.168.160.1');

        $this->assertEquals(1, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }

    public function testFindIntersecting_RangeSurrounding_ReturnsIpRange()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.50.1');
        $ipRange->setEndIp('192.168.240.1');

        $this->assertEquals(1, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }

    public function testFindIntersecting_RangeBelow_ReturnsEmpty()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.50.1');
        $ipRange->setEndIp('192.168.60.1');

        $this->assertEquals(0, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }

    public function testFindIntersecting_RangeAbove_ReturnsEmpty()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.220.1');
        $ipRange->setEndIp('192.168.230.1');

        $this->assertEquals(0, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }

    public function testFindIntersecting_RangeBottom_ReturnsIpRange()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.80.1');
        $ipRange->setEndIp('192.168.100.1');

        $this->assertEquals(1, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }

    public function testFindIntersecting_RangeTop_ReturnsIpRange()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.168.199.255');
        $ipRange->setEndIp('192.168.220.1');

        $this->assertEquals(1, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }
}

