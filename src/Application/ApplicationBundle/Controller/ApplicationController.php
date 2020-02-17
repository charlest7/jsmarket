<?php

namespace Application\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\ApplicationBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Application\ApplicationBundle\Entity\Product;
use Application\ApplicationBundle\Entity\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\ApplicationBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;


class ApplicationController extends Controller
{

     /**
     * Lists all application entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('AppApplicationBundle:Customer')->findAll();

        return $this->render('AppApplicationBundle:Application:index.html.twig', array(
            'customers' => $customers,
            'customerName' => 'linda'
        ));
    }

    public function getPointsAction(Request $request){
        $userEmail = $request->query->get('UserEmail');
        
        $em = $this->getDoctrine()->getManager();
        $customerEntity = $em->getRepository('AppApplicationBundle:Customer')->findOneBy(array('customerEmail'=> $userEmail));

        return new JsonResponse(array('message' => 'tes'), 200);
    }
}
