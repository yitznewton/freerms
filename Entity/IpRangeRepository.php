<?php

namespace Yitznewton\FreermsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IpRangeRepository
 */
class IpRangeRepository extends EntityRepository
{
    /**
     * @param IpRange $testIpRange The IpRange to test against
     * @param bool $activeOnly Whether to test only active IpRanges
     */
    public function findIntersecting(IpRange $testIpRange, $activeOnly = true)
    {
        // algorithm explained at
        // http://stackoverflow.com/questions/143552/comparing-date-ranges
        $queryBuilder = $this->createQueryBuilder('i')
            ->where('i.start_ip_sort <= :end_ip_sort')
            ->andWhere('i.end_ip_sort >= :start_ip_sort');

        if ($activeOnly) {
            $queryBuilder->andWhere('i.is_active = true');
        }

        $queryBuilder->setParameters(array(
            'start_ip_sort' => $testIpRange->getStartIpSort(),
            'end_ip_sort'   => $testIpRange->getEndIpSort(),
        ));

        return $queryBuilder->getQuery()->getResult();
    }
}

