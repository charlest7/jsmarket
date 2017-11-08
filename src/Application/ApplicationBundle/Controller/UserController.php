<?php

namespace Application\ApplicationBundle\Controller;

use Application\ApplicationBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * User controller.
 *
 */
class UserController extends Controller
{
	
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppApplicationBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Application\ApplicationBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	
        	$entityRepo = $this->getDoctrine()->getRepository('AppApplicationBundle:User')->findOneBy(array('username'=> $user->getUsername(), 'password' => $user->getPassword()));
        	
        	
        	if( !empty($entityRepo))
        	{
        
        		$session = new Session();
        		$session->set('username', $entityRepo->getUsername());
        		$session->set('timeout', time());
        		return $this->redirectToRoute('product_index');
        	}else{
        		return $this->render('user/new.html.twig', array(
        				'user' => $user,
        				'form' => $form->createView(),
        		));
        	}
        	
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Application\ApplicationBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
     /**
     * logout
     *
     *
     **/
    public function logoutAction(Request $request)
    {
    
    	
    	$session = new Session();
    	
    	$usernameSession =  $session->get('username');
    	echo $usernameSession;
    	
    	if(!empty($usernameSession))
    	{
    		$session->remove('username');
    		echo $session->get('username');
    		
    		
    	}
    	return $this->render('user/new.html.twig');
    	
    } 
    
     /**
      * logout
      *
      *
      **/
      public function redirectAction(Request $request)
      {
      	
      	$session = new Session();
      	
      	$session->remove('username');
      	$session->remove('timeout');
      	
      	echo $session->get('username');
           
      	return $this->redirectToRoute('user_new');
      
      }
      
      
     
}
