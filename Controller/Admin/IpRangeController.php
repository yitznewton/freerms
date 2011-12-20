<?php

namespace Yitznewton\FreermsBundle\Controller\Admin;

use Symfony\Component\DependencyInjection\ContainerAware;

class IpRangeController extends ContainerAware
{
    public function indexAction()
    {
        $ipRanges = $this->container->get('doctrine')->getEntityManager()
            ->getRepository('FreermsBundle:IpRange')->findAll();

        return $this->container->get('templating')
            ->renderResponse('FreermsBundle:Admin/IpRange:index.html.twig',
                             array('ipRanges' => $ipRanges));
    }
}

