<?php

namespace Application\ApplicationBundle\Controller;

use Application\ApplicationBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\ApplicationBundle\Entity\Customer;
use Application\ApplicationBundle\Entity\Product;

/**
 * Transaction controller.
 *
 */
class TransactionController extends Controller
{
    /**
     * Lists all transaction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transactions = $em->getRepository('AppApplicationBundle:Transaction')->findAll();
        

        return $this->render('AppApplicationBundle:Transaction:index.html.twig', array(
            'transactions' => $transactions,
        ));
    }

    /**
     * Creates a new transaction entity.
     *
     */
    public function newAction(Request $request)
    {
        $transaction = new Transaction();
        $form = $this->createForm('Application\ApplicationBundle\Form\TransactionType', $transaction);
        $form->handleRequest($request);

        
        $em = $this->getDoctrine()->getManager();
        
        $listProducts = $em->getRepository('AppApplicationBundle:Product');
        
        $query = $listProducts->createQueryBuilder('p')
        ->where('p.status != :status')
        ->setParameter('status', 'sell')
        ->getQuery();
        $listProductsVal = $query->getResult();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return $this->redirectToRoute('transaction_show', array('id' => $transaction->getId()));
        }

        return $this->render('AppApplicationBundle:Transaction:new.html.twig', array(
        		'listProducts' => $listProductsVal,
            'transaction' => $transaction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transaction entity.
     *
     */
    public function showAction(Transaction $transaction)
    {
        $deleteForm = $this->createDeleteForm($transaction);

        return $this->render('transaction/show.html.twig', array(
            'transaction' => $transaction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transaction entity.
     *
     */
    public function editAction(Request $request, Transaction $transaction)
    {
        $deleteForm = $this->createDeleteForm($transaction);
        $editForm = $this->createForm('Application\ApplicationBundle\Form\TransactionType', $transaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_edit', array('id' => $transaction->getId()));
        }

        return $this->render('transaction/edit.html.twig', array(
            'transaction' => $transaction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transaction entity.
     *
     */
    public function deleteAction(Request $request, Transaction $transaction)
    {
        $form = $this->createDeleteForm($transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transaction);
            $em->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }

    /**
     * Creates a form to delete a transaction entity.
     *
     * @param Transaction $transaction The transaction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transaction $transaction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transaction_delete', array('id' => $transaction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function checkValueCustomerIdAction(Request $request)
    {
    	$customerId = $request->query->get('customerId');
    	
    	$entityRepo = $this->getDoctrine()->getManager()->getRepository('AppApplicationBundle:Customer')->findOneBy(array('customerId'=> $customerId));
    	
    	
    	if(!empty($entityRepo)){
    		return new JsonResponse(array('message' =>  $entityRepo), 200);
    	}else{
    		return new JsonResponse(array('message' =>  $customerId), 400);
    	}
    	
    }
    
    public function addProductToCartAction(Request $request)
    {
    	
    	$productId = $request->query->get('productId');
    	
    	$entityRepo = $this->getDoctrine()->getManager()->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> '1807010002'));
    	
    	
    	
    		return new JsonResponse(array('message' =>  $entityRepo), 200);
    	
    	
    }
    
    public function completePurchaseAction(Request $request)
    {
    	
    	$transactionDetails = $request->query->get('purchaseDetails');
    	
    	$entityProduct = $this->getDoctrine()->getManager();
    	$productSell = [];
    	$em = $this->getDoctrine()->getManager();
    	
    	$currDate = date('Y-m-d H:i:s');
    	
    	
        $paymentMethod = array("Cash"=>"CS","Debit"=>"DB","Credit card"=>"CC" );
        $entityRepository = $this->getDoctrine()->getRepository('AppApplicationBundle:Transaction');
            
      
       
        $result = 0;
    /*	$valTransactionId = substr($lastTransactionId->getTransactionId(),2);
    	$newTransactionId = $paymentMethod[$transactionDetails[4]].$valTransactionId;
    		
    	for($x=0;$x<count($transactionDetails[0]);$x++)
    	{
    		$productTransaction = $transactionDetails[0][$x];
    		$product = $entityProduct->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> $productTransaction[0]));
    		
    		$product->setTransactionId($newTransactionId);
    		$product->setStatus("sell");
    		$product->setSellDate(new \DateTime($currDate));
    		$product->setSellPrice($productTransaction[1]); 
    		
    		$entityProduct->persist($product);
    		$entityProduct->flush();    		
    	 		
    		array_push($productSell,$product->getStatus());
    	}
    	
    	$transaction = new Transaction();
    	
    	$transactionEntity = $entityProduct->getRepository('AppApplicationBundle:Transaction')->findOneBy(array('transactionId'=> 'DESC'));;
    	
    	$transaction->setTransactionId("13");
    	$transaction->setTransactionDate(new \DateTime($currDate));
    	$transaction->setTransactionStoreId("01");
    	$transaction->setTransactionTotalItem($transactionDetails[2]);
    	$transaction->setTransactionTotalTransaction($transactionDetails[3]);
    	$transaction->setTransactionPaymentType($transactionDetails[4]);
    	$transaction->setTransactionTotalPayment("N/a");
    	$transaction->setTransactionTotalChangeDue("N/A");
    	
    	
    	$em->persist($transaction);
    	$em->flush();
        
        */
    	
    	
    
    	
    	
    	if(!empty($productSell)){
    		return new JsonResponse(array('message' =>  $result->getTransactionId()), 200);
    	}else{
    	}
    	
    }

    /**
     * Lists all transaction entities.
     *
     */
    public function indexJsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transactions = $em->getRepository('AppApplicationBundle:Transaction')->findAll();

        $listProducts = $em->getRepository('AppApplicationBundle:Product');
        $query = $listProducts->createQueryBuilder('p')
        ->where('p.status != :status')
        ->setParameter('status', 'sell')
        ->getQuery();
        $listProductsVal = $query->getResult();
        

        return $this->render('AppApplicationBundle:Transaction:indexJs.html.twig', array(
            'transactions' => $transactions,
            'listProducts' => $listProductsVal
        ));
    }

}
