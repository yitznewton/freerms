<?php

namespace Yitznewton\FreermsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IpRangeController extends Controller
{
    public function indexAction()
    {
        return $this->render('YitznewtonFreermsBundle:Admin/IpRange:index.html.twig', array('name' => 'jimm'));
    }
}

