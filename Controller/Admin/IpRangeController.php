<?php

namespace Yitznewton\FreermsBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Yitznewton\FreermsBundle\Admin\IpRangeAdmin;

/**
 * @Route("/ip")
 */
class IpRangeController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function listAction()
    {
        $view = 'YitznewtonFreermsBundle:Admin/IpRange:list.html.twig';
        $content = $this->renderView($view);
        return new Response($content);
    }
}

