<?php

namespace Yitznewton\FreermsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IpRangeController extends Controller
{
    public function indexAction()
    {
        $ipRanges = $this->getDoctrine()->getEntityManager()
            ->getRepository('FreermsBundle:IpRange')->findAll();

        return $this->render('FreermsBundle:Admin/IpRange:index.html.twig',
            array('ipRanges' => $ipRanges));
    }
}

