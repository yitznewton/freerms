<?php

namespace Yitznewton\FreermsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IpRangeController extends Controller
{
    public function indexAction()
    {
        $ipRanges = $this->getDoctrine()->getRepository('YitznewtonFreermsBundle:IpRange')
            ->findAll();

        return $this->render('YitznewtonFreermsBundle:Admin/IpRange:index.html.twig',
            array('ipRanges' => $ipRanges));
    }
}

