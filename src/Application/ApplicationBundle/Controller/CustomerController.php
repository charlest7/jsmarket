<?php

namespace Application\ApplicationBundle\Controller;

use Application\ApplicationBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Application\ApplicationBundle\Entity\Product;
use Application\ApplicationBundle\Entity\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
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

        return $this->render('AppApplicationBundle:Customer:index.html.twig', array(
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
        $statusTransaction = true;
        $transactionData = false;
        
        for($x=0;$x<count($transactionDetails[0]);$x++)
    	{
    		$productTransaction = $transactionDetails[0][$x];
            $product = $entityProduct->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> $productTransaction));

            if($product->getStatus() == "sell"){
                $statusTransaction = false;
            }

        }

        if($statusTransaction == true){
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
        $transaction->setTransactionCustomerId($transactionDetails[1]);


    	
    	
    	$em->persist($transaction);
        $em->flush();
        
        $customer = $entityProduct->getRepository('AppApplicationBundle:Customer')->findOneBy(array('customerId'=> $transactionDetails[1]));
        $totalPointsTransaction = round($transactionDetails[3]/1000);
        $adjustmentPoints = $totalPointsTransaction+$customer->getCustomerPoints();
        $customer->setCustomerPoints($adjustmentPoints);

        $em->persist($customer);
        $em->flush();

        $this->sendEmailAction($customer->getCustomerId());
        $transactionData  = [$transaction->getTransactionId($transactionDetails[1]),hash("sha256", $customer->getCustomerEmail())];

      

        }else{
            $transactionData = false;
        }
        
        
    	return new JsonResponse(array('message' => $transactionData), 200);
    
    	
    }


    public function sendEmailAction($customerId)
    {
    $message = (new \Swift_Message('Transaction Receipt'))
        ->setFrom('admtrimatics@gmail.com')
        ->setTo('charlestendeanz@gmail.com')
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'AppApplicationBundle:Transaction:transactionReceipt.html.twig',
                ['title' => 'Transaction Receipt',
                'customerId' => $customerId,
                'email' => 'shahroze.nawaz@cloudways.com'
                ]
            ),
            'text/html'
        )

        // you can remove the following code if you don't define a text version for your emails
        ->addPart(
            $this->renderView(
                'AppApplicationBundle:Transaction:transactionReceipt.html.twig',
                ['title' => 'Transaction Receipt',
                'customerId' => $customerId,
                'email' => 'shahroze.nawaz@cloudways.com'
                ]
            ),
            'text/plain'
        )
    ;

    $this->get('mailer')->send($message);
   // return $this->render('AppApplicationBundle:Transaction:sendEmail.html.twig', array(
       // 'transactions' => 'transaction'
   // ));
   return true;
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

    public function getPointsAction(Request $request){
        $session = new Session();
        
        $em = $this->getDoctrine()->getManager();
        $customerEntity = $em->getRepository('AppApplicationBundle:Customer')->findOneBy(array('customerEmail'=> $session->get('username')));

        if($customerEntity != null){
            $serializer = $this->container->get('serializer');           
            $customerEntity = $serializer->serialize($customerEntity, 'json');
            return new JsonResponse(array('message' => $customerEntity, Response::HTTP_OK, ['content-type' => 'application/json']), 200);
        }else{
            return new JsonResponse(array('message' => $session->get('username')), 200);
        }
    }

    public function loginCustomerAppsAction(Request $request){
        $userData = $request->query->get('userData');

        $em = $this->getDoctrine()->getManager();
        $userEntity = $em->getRepository('AppApplicationBundle:User')->findOneBy(array('username'=> $userData[0],'password' => hash("sha256", $userData[1]) ));

        $session = new Session();
        $status = false;
        if($userEntity != null && $session->get('username') == null){
            $session->set('username', $userEntity->getUsername());
            $session->set('timeout', time());
            $session->set('typeUser', $userEntity->getType());
        }else if( $userEntity != null && $session->get('username') != null){
            $status = 'Already Log In';
        }

        //$em = $this->getDoctrine()->getManager();
        //$customerEntity = $em->getRepository('AppApplicationBundle:Customer')->findOneBy(array('customerEmail'=> $userData[0],'customerPassword' =>hash("sha256", $userData[1]) ));
        return new JsonResponse(array('message' => $session->get('username') ), 200);
    }

    public function sendEmailConfirmationToNewUserAction(Request $request)
    {
    	
        $customerEmail = $request->query->get('customerEmail');
        
        $this->sendEmailInvitationNewUserAction("hah");
    	
    	return new JsonResponse(array('message' => 'ddfsd'), 200);	
    }

    public function sendEmailInvitationNewUserAction($customerEmail)
    {
        $value = "Thank You for coming, Please visit http://192.168.43.115/jsmarket/web/app_dev.php/application/?customerEmail=".$customerEmail;
    $message = (new \Swift_Message('Email Invitation'))
        ->setFrom('admtrimatics@gmail.com')
        ->setTo('charlestendeanz@gmail.com')
        ->setBody(
           $value
        );

        

        $this->get('mailer')->send($message);

         return true;
   }
}
