<?php

namespace Application\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Default controller.
 *
 */
class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $view = 'AppApplicationBundle:Default:new_default.html.twig';
        return $this->render($view);
    }
    
   
    
}
