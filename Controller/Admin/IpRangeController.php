<?php

namespace Yitznewton\FreermsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yitznewton\FreermsBundle\Model;

class IpRangeController extends Controller
{
    public function indexAction()
    {
        $ipRanges = Model\IpRangeQuery::create()->find();

        return $this->render('FreermsBundle:Admin/IpRange:index.html.twig',
            array('ipRanges' => $ipRanges));
    }
}

