<?php

namespace CuctomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CuctomerBundle:Default:index.html.twig');
    }
}
