<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * 
     */
    public function indexAction(Request $request)
    {
    	$authenticationUtils = $this->get('security.authentication_utils');
    	
    	// get the login error if there is one
    	$error = $authenticationUtils->getLastAuthenticationError();
    	
    	// last username entered by the user
    	$lastUsername = $authenticationUtils->getLastUsername();
    	
    	return $this->render('security/login.html.twig', array(
    			'last_username' => $lastUsername,
    			'error'         => $error,
    	));
    }
    
    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
    	// replace this example code with whatever you need
    	$authenticationUtils = $this->get('security.authentication_utils');
    	 
    	// get the login error if there is one
    	$error = $authenticationUtils->getLastAuthenticationError();
    	 
    	// last username entered by the user
    	$lastUsername = $authenticationUtils->getLastUsername();
    	 
    	return $this->render('default/index.html.twig', array(
    			'last_username' => $lastUsername,
    			'error'         => $error,
    	));
    }
}
