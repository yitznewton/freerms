<?php

namespace Yitznewton\FreermsBundle\Tests\Model;

use Yitznewton\FreermsBundle\Model\IpRange;

class IpRangeTest extends \PHPUnit_Framework_TestCase
{
    public function testSetStartIp_ValidIp_SetsStartIpSort()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('92.245.1.1');
        $this->assertAttributeEquals('092245001001', 'start_ip_sort', $ipRange,
            'IpRange::setStartIp() sets start_ip_sort correctly');
    }

    public function testSetEndIp_ValidIp_SetsEndIpSort()
    {
        $ipRange = new IpRange();
        $ipRange->setEndIp('92.245.1.1');
        $this->assertAttributeEquals('092245001001', 'end_ip_sort', $ipRange,
            'IpRange::setEndIp() sets end_ip_sort correctly');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStartIp_InvalidIp_Rejects()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('292.245.1.1');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetEndIp_InvalidIp_Rejects()
    {
        $ipRange = new IpRange();
        $ipRange->setEndIp('292.245.1.1');
    }

    public function testSetEndIpForSingle_SaveSingle_SetsEndIp()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');
        $ipRange->save();

        $this->assertEquals('192.245.1.1', $ipRange->getEndIp(),
            'IpRange::endIp set on save of single IP address');
    }

    public function testSetEndIpForSingle_SaveRange_NotSetsEndIp()
    {
        $this->markTestSkipped();
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');
        $ipRange->setEndIp('192.245.1.2');

        $this->_em->persist($ipRange);

        $this->assertEquals('192.245.1.2', $ipRange->getEndIp(),
            'IpRange::endIp not set on persist of IP address range');
    }
}

