<?php

namespace RfidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('RfidBundle:Home:index.html.twig');
    }
}
