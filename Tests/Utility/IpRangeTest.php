<?php

namespace Yitznewton\FreermsBundle\Tests\Utility;

use Doctrine\Tests\OrmTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Yitznewton\FreermsBundle\Entity\IpRange;

class IpRangeTest extends OrmTestCase
{
    protected $_em;

    protected function setUp()
    {
        $reader = new AnnotationReader();
        $reader->setIgnoreNotImportedAnnotations(true);
        $reader->setEnableParsePhpImports(true);

        $metadataDriver = new AnnotationDriver( 
            $reader, 'Yitznewton\\FreermsBundle\\Entity'
        );

        $this->_em = $this->_getTestEntityManager();

        $this->_em->getConfiguration()
            ->setMetadataDriverImpl($metadataDriver);

        $this->_em->getConfiguration()->setEntityNamespaces(array(
            'YitznewtonFreermsBundle' => 'Yitznewton\\FreermsBundle\\Entity'));
    }

    public function testSetStartIp_ValidIp_SetsStartIpSort()
    {
        $ipRange = new IpRange();
        $ipRange->setStartIp('92.245.1.1');
        $this->assertEquals('092245001001', $ipRange->getStartIpSort(),
            'IpRange::setStartIp() sets startIpSort correctly');
    }

    public function testSetEndIp_ValidIp_SetsEndIpSort()
    {
        $ipRange = new IpRange();
        $ipRange->setEndIp('92.245.1.1');
        $this->assertEquals('092245001001', $ipRange->getEndIpSort(),
            'IpRange::setEndIp() sets endIpSort correctly');
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
        $ipRange = new IpRange();
        $ipRange->setStartIp('192.245.1.1');

        $this->_em->persist($ipRange);

        $this->assertEquals('192.245.1.1', $ipRange->getEndIp(),
            'IpRange::endIp set on persist of single IP address');
    }

    public function testSetEndIpForSingle_PersistRange_NotSetsEndIp()
    {
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

