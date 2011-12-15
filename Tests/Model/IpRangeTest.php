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

    public function testSetEndIpForSingle_PersistSingle_SetsEndIp()
    {
        $this->markTestSkipped();
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');

        $this->_em->persist($ipRange);

        $this->assertEquals('192.245.1.1', $ipRange->getEndIp(),
            'IpRange::endIp set on persist of single IP address');
    }

    public function testSetEndIpForSingle_PersistRange_NotSetsEndIp()
    {
        $this->markTestSkipped();
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');
        $ipRange->setEndIp('192.245.1.2');

        $this->_em->persist($ipRange);

        $this->assertEquals('192.245.1.2', $ipRange->getEndIp(),
            'IpRange::endIp not set on persist of IP address range');
    }

    /**
     * @see http://doctrine-project.org/jira/browse/DDC-1528
     */
    public function testSetEndIpForSingle_UpdateSingle_SetsEndIp()
    {
        $this->markTestSkipped('Doctrine mock broken');

        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');
        $ipRange->setEndIp('192.245.1.2');

        $this->_em->persist($ipRange);
        $this->_em->flush();

        $ipRange->setStartIp('192.245.2.1');
        $ipRange->setEndIp(null);

        $this->_em->flush();

        $this->assertEquals('192.245.2.1', $ipRange->getEndIp(),
            'IpRange::endIp set on update of single IP address');
    }

    /**
     * @see http://doctrine-project.org/jira/browse/DDC-1528
     */
    public function testSetEndIpForSingle_UpdateRange_NotSetsEndIp()
    {
        $this->markTestSkipped('Doctrine mock broken');
    }
}

