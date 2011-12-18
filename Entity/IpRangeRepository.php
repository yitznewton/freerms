<?php

namespace Yitznewton\FreermsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IpRangeRepository
 */
class IpRangeRepository extends EntityRepository
{
    public function findIntersecting(IpRange $testIpRange)
    {
        // algorith explained at http://stackoverflow.com/questions/143552/comparing-date-ranges
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT i FROM FreermsBundle:IpRange i
                WHERE i.start_ip <= :end_ip AND i.end_ip >= :start_ip
            ')->setParameters(
                array(
                    'start_ip' => $testIpRange->getStartIp(),
                    'end_ip'   => $testIpRange->getEndIp(),
                )
            );

        return $query->getResult();
    }
}

