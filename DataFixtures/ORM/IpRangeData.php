<?php

namespace Yitznewton\FreermsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Yitznewton\FreermsBundle\Entity\IpRange;

class IpRangeData implements FixtureInterface
{
    public function load($em)
    {
        $data = array(
            array(
                'start_ip'  => '192.168.1.1',
                'end_ip'    => '192.168.1.100',
                'is_active' => true,
                'is_excluded' => false,
            ),
            array(
                'start_ip'  => '192.168.2.1',
                'end_ip'    => '192.168.2.100',
                'is_active' => false,
                'is_excluded' => false,
            ),
            array(
                'start_ip'  => '192.168.3.1',
                'end_ip'    => '192.168.3.1',
                'is_active' => true,
                'is_excluded' => false,
            ),
            array(
                'start_ip'  => '192.168.1.37',
                'end_ip'    => '192.168.1.37',
                'is_active' => true,
                'is_excluded' => true,
            ),
        );

        foreach ($data as $item) {
            $ipRange = new IpRange();
            $ipRange->setStartIp($item['start_ip']);
            $ipRange->setEndIp($item['end_ip']);
            $ipRange->setIsActive($item['is_active']);
            $ipRange->setIsExcluded($item['is_excluded']);

            $em->persist($ipRange);
        }

        $em->flush();
    }
}

