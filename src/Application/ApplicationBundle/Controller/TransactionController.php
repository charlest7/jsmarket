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

        return $this->render('transaction/index.html.twig', array(
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
        
        $listProducts = $em->getRepository('AppApplicationBundle:Product')->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return $this->redirectToRoute('transaction_show', array('id' => $transaction->getId()));
        }

        return $this->render('AppApplicationBundle:Transaction:new.html.twig', array(
        	'listProducts' => $listProducts,
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
    	
    	$entityRepo = $this->getDoctrine()->getManager()->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> $productId));
    	
    	
    	
    	if(!empty($entityRepo)){
    		return new JsonResponse(array('message' =>  $entityRepo), 200);
    	}else{
    		return new JsonResponse(array('message' =>  $entityRepo), 400);
    	}
    	
    }
    
    public function completePurchaseAction(Request $request)
    {
    	
    	$transactionDetails = $request->query->get('purchaseDetails');
    	
    	$entityProduct = $this->getDoctrine()->getManager();
    	
    	
    	
    	for($x=0;$x<count($transactionDetails[0]);$x++)
    	{
    		$productTransaction = $transactionDetails[0][$x];
    		
    		
    		
    	}
    	
    	$product = $entityProduct->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> '170410006'));
    	
    	$product->setStatus("sell");
    	$entityProduct->persist($product);
    	$entityProduct->flush();
    	return new JsonResponse(array('message' =>  $product->getStatus()), 200);
    	
    	if(empty($transactionDetails)){
    		
    	}else{
    	}
    	
    }
}
