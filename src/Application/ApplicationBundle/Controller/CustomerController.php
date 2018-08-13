<?php

namespace Application\ApplicationBundle\Controller;

use Application\ApplicationBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Application\ApplicationBundle\Entity\Product;
use Application\ApplicationBundle\Entity\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\ApplicationBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * Customer controller.
 *
 */
class CustomerController extends Controller
{
    /**
     * Lists all customer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('AppApplicationBundle:Customer')->findAll();

        return $this->render('customer/index.html.twig', array(
            'customers' => $customers,
        ));
    }

    /**
     * Creates a new customer entity.
     *
     */
    public function newAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm('Application\ApplicationBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customer_show', array('id' => $customer->getId()));
        }

        return $this->render('AppApplicationBundle:Customer:new.html.twig', array(
            'customer' => $customer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a customer entity.
     *
     */
    public function showAction(Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);

        return $this->render('customer/show.html.twig', array(
            'customer' => $customer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing customer entity.
     *
     */
    public function editAction(Request $request, Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);
        $editForm = $this->createForm('Application\ApplicationBundle\Form\CustomerType', $customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_edit', array('id' => $customer->getId()));
        }

        return $this->render('customer/edit.html.twig', array(
            'customer' => $customer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a customer entity.
     *
     */
    public function deleteAction(Request $request, Customer $customer)
    {
        $form = $this->createDeleteForm($customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('customer_index');
    }

    /**
     * Creates a form to delete a customer entity.
     *
     * @param Customer $customer The customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Customer $customer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function completePurchaseAction(Request $request)
    {
    	
    	$transactionDetails = $request->query->get('purchaseDetails');
    	
    	$entityProduct = $this->getDoctrine()->getManager();
    	$productSell = [];
    	$em = $this->getDoctrine()->getManager();
    	
    	$currDate = date('Y-m-d');
    	
    	
    	$paymentMethod = array("Cash"=>"CS","Debit"=>"DB","Credit Card"=>"CC" );
    	$entityTransaction = $entityProduct->getRepository('AppApplicationBundle:Transaction');
    	$query = $entityTransaction->createQueryBuilder('alias')
		    	->select('alias.id')
		    	->setMaxResults(1)
		    	->orderBy('alias.id','DESC')
		    	->getQuery();
        $result = $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        $newTransactionId = "0";
        if($result == null){

            $newTransactionId = $paymentMethod[$transactionDetails[4]]."1";
        }else{
            $lastEntityTransaction = $entityTransaction->findOneBy(array('id' => $result));
    	    $valTransactionId = substr($lastEntityTransaction->getTransactionId(),2)+1;
    	    $newTransactionId = $paymentMethod[$transactionDetails[4]].$valTransactionId;
        }
        
    	for($x=0;$x<count($transactionDetails[0]);$x++)
    	{
    		$productTransaction = $transactionDetails[0][$x];
    		
    		
    		
    		
    		$product = $entityProduct->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> $productTransaction));
    		
    		
    	    $product->setTransId($newTransactionId);
    		$product->setStatus("sell");
    		$product->setSellDate(new \DateTime($currDate));
    		
    		if($productTransaction[1] == 0)
    		{
    			$product->setSellPrice($product->getPrice());
    		}else{
    			$product->setSellPrice($productTransaction[1]);
    		}
    		
    		
    		$entityProduct->persist($product);
    		$entityProduct->flush();
    		
    		
    		
    		array_push($productSell,$product->getStatus());
    	}
    	
    	$transaction = new Transaction();
    	    	
    	$transaction->setTransactionId($newTransactionId);
    	$transaction->setTransactionDate(new \DateTime($currDate));
    	$transaction->setTransactionStoreId("01");
    	$transaction->setTransactionTotalItem($transactionDetails[2]);
    	$transaction->setTransactionTotalTransaction($transactionDetails[3]);
    	$transaction->setTransactionPaymentType($transactionDetails[4]);
    	$transaction->setTransactionTotalPayment("N/a");
    	$transaction->setTransactionTotalChangeDue("N/A");
    	
    	
    	$em->persist($transaction);
    	$em->flush();
    	
    	if(!empty($productSell)){
    		return new JsonResponse(array('message' => 'success'), 200);
    	}else{
    	}
    	
    }
    
    /**
     * login session
     *
     *
     **/
    public function loginAction(Request $request)
    {
    	
    	$login = $request->query->get('userLogin');
    	
    	
    	$user = $this->getValUser($login);
    	
    	
    	if(!empty($user)){
    		
    		$session = new Session();
    		$session->set('username', $user->getUsername());
    		$session->set('timeout', time());
    		
    		return new JsonResponse(array('message' =>  $login), 200);
    	}else{
    		return new JsonResponse(array('message' =>  "dsafdsa"), 400);
    	}
    	
    }
    
    public function getValUser($user)
    {
    	$user = $this->getDoctrine()->getRepository('AppApplicationBundle:User')->findOneBy(array('username'=> $user[0], 'password' => $user[1]));
    	
    	return $user;
    }
}
