<?php

namespace Yitznewton\FreermsBundle\Tests\Utility;

use Yitznewton\FreermsBundle\Entity\IpRange;

class IpRangeTest extends \PHPUnit_Framework_TestCase
{
    public function testSetStartIp()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');
        $this->assertEquals(3237282049, $ipRange->getStartIpInt(),
            'IpRange::setStartIp() sets startIpInteger correctly');
    }

    public function testSetEndIp()
    {
        $ipRange = new IpRange();
        $ipRange->setEndIp('192.245.1.1');
        $this->assertEquals(3237282049, $ipRange->getEndIpInt(),
            'IpRange::setEndIp() sets endIpInteger correctly');
    }
}

