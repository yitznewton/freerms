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
        $ipRange->setStartIp('192.150.1.1');
        $ipRange->setEndIp('192.160.1.1');

        $this->assertEquals(1, count($this->getRepository()
            ->findIntersecting($ipRange)));
    }
}

