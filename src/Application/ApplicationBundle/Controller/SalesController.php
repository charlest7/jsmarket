<?php

namespace Application\ApplicationBundle\Controller;

use Application\ApplicationBundle\Entity\Sales;
use Application\ApplicationBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sale controller.
 *
 */
class SalesController extends Controller
{
    /**
     * Lists all sale entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sales = $em->getRepository('AppApplicationBundle:Sales')->findAll();

        return $this->render('AppApplicationBundle:Sales:index.html.twig', array(
            'sales' => $sales,
        ));
    }

    /**
     * Creates a new sale entity.
     *
     */
    public function newAction(Request $request)
    {
        $sale = new Sales();
        $form = $this->createForm('Application\ApplicationBundle\Form\SalesType', $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
           
            $productRepository = $this->getDoctrine()->getRepository('AppApplicationBundle:Product');
            $product = $productRepository->findOneBy(
    array('productId' => $sale->getProductIdSales()));
            
            if (!$product || $product->getStatus == 'sold') {
            	return $this->render('AppApplicationBundle:Sales:new.html.twig', array(
            			'error' => 'Product not found',
            			'form' => $form->createView(),
            	));
            }
            
            $entityRepository = $this->getDoctrine()->getRepository('AppApplicationBundle:Sales');
            
            $query = $entityRepository->createQueryBuilder('alias')
            ->select('alias.transactionIdSales')
            ->setMaxResults(1)
            ->orderBy('alias.transactionIdSales','DESC')
            ->getQuery();
            $result = $query->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            
         	//get transaction id
            $transactionId = implode(" ",$result);
            $currTransactionId = $transactionId+1;
            
            //to get profit
            $modal = $product->getCapital();

            $profit = $sale->getSalePriceSales() - $modal;
            
            //get date sales
            $currDate = date('Y-m-d H:i:s');
         
            $product->setStatus("Sold");
            $sale->setTransactionIdSales($currTransactionId);
            $sale->setProfitSales($profit);
            $sale->setDateSales(new \DateTime($currDate));
            $sale->setPrice($product->getPrice());
            
            $em->persist($sale);
            $em->flush();

            return $this->redirectToRoute('sales_index', array('id' => $sale->getId()));
        }

        return $this->render('AppApplicationBundle:Sales:new.html.twig', array(
            'sale' => $sale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sale entity.
     *
     */
    public function showAction(Sales $sale)
    {
        $deleteForm = $this->createDeleteForm($sale);

        return $this->render('sales/show.html.twig', array(
            'sale' => $sale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sale entity.
     *
     */
    public function editAction(Request $request, Sales $sale)
    {
        $deleteForm = $this->createDeleteForm($sale);
        $editForm = $this->createForm('Application\ApplicationBundle\Form\SalesType', $sale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sales_edit', array('id' => $sale->getId()));
        }

        return $this->render('sales/edit.html.twig', array(
            'sale' => $sale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sale entity.
     *
     */
    public function deleteAction(Request $request, Sales $sale)
    {
        $form = $this->createDeleteForm($sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sale);
            $em->flush();
        }

        return $this->redirectToRoute('sales_index');
    }

    /**
     * Creates a form to delete a sale entity.
     *
     * @param Sales $sale The sale entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sales $sale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sales_delete', array('id' => $sale->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
