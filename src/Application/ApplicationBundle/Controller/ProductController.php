<?php

namespace Application\ApplicationBundle\Controller;

use Application\ApplicationBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\ApplicationBundle\Entity\Customer;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppApplicationBundle:Product')->findAll();
        
        return $this->render('AppApplicationBundle:Product:index.html.twig', array(
            'products' => $products,
        ));
    }
    
    
    /**
    * Lists all product entities.
    *
    */
   public function indexNewAction()
   {
       $em = $this->getDoctrine()->getManager();

       $products = $em->getRepository('AppApplicationBundle:Product')->findAll();
       
       return $this->render('AppApplicationBundle:Product:index_new.html.twig', array(
           'products' => $products,
       ));
   }
    

    
    /**
     *
     * @Route("/template", name="template")
     */
    public function showTemplate(Request $request)
    {
    	$view = 'AppApplicationBundle:Product:show_template.html.twig';
    	return $this->render($view);
    }

    /**
     * Creates a new product entity.
     *
     */
  /*  public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('Application\ApplicationBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entityRepository = $this->getDoctrine()->getRepository('AppApplicationBundle:Product');
            
            $query = $entityRepository->createQuueryBuilder('alias')
            		->select('alias.productId')
            		->setMaxResults(1)
            		->orderBy('alias.productId','DESC')
            		->getQuery();
            $result = $query->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            
            $product->setCustomerid("000");
            echo $product->getType()." ".$product->getStatus();
            //set date
            $currDate = date('Y-m-d');
            $product->setDate(new \DateTime($currDate));
                        
            $lastIndexProduct = substr($result, 4);
            
            echo $lastIdProduct." ";
            $valIndexProduct = "";
            for($x=0;$x<4;$x++){
            	if($lastIndexProduct[$x] != 0 ){
            		$valIndexProduct = $valIndexProduct.$lastIndexProduct[$x];
            	}
            }
            echo $valIndexProduct.' ';
            
            $currIndexProductNull = "";
            if( substr($currDate,5,2)  == substr($lastIdProduct,2,2)){  
            	
            	$currIndexProductPartial = $valIndexProduct+1;
            	$currIndexProductNull;
            	
            	for($x=0;$x<4-strlen($currIndexProductPartial);$x++){
            		$currIndexProductNull = $currIndexProductNull."0";
            	}   
            	
            	$currIndexProduct = $currIndexProductNull.$currIndexProductPartial;
            }else{
            	$currIndexProduct = "0001";
            }
            
            $newProductId = substr($currDate,2,2).substr($currDate,5,2)."1".$currIndexProduct;
            
            $product->setProductId($newProductId);
            $product->setTransactionId("0");
            $product->setTransId("0");
            $product->setSellPrice("0");
            
           // echo substr($currDate,2,2);
            //echo substr($currDate,5,2);
          
            //echo $product->getId();
           
            
            
            //$products = $em->getRepository('AppApplicationBundle:Product')->findOneBy(array('collaborateur'=>$collaborateur),array('id' => 'DESC'));
            
            $em->persist($product);
            $em->flush($product);

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('AppApplicationBundle:product:product_form.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }


*/
    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('Application\ApplicationBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('AppApplicationBundle:product:edit.html.twig', array(
            'product' => $product,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush($product);
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    

    
    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function productFormAction(Request $request)
    {
    	
    	return $this->render('AppApplicationBundle:product:base.html.twig');
    }
    
    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function addProductToCartAction(Request $request)
    {
    	
    	$customerId = $request->query->get('customerId');
    	
    	$entityRepo = $this->getDoctrine()->getManager()->getRepository('AppApplicationBundle:Product')->findOneBy(array('productId'=> $customerId));
    
    	if(!empty($entityRepo)){
    		return new JsonResponse(array('message' =>  $entityRepo), 200);
    	}else{
    		return new JsonResponse(array('message' =>  $entityRepo), 400);
    	}
    	
    }
    
    
    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function exportDataProductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $products = $em->getRepository('AppApplicationBundle:Product')->findAll();
        
        
        
        return $this->render('AppApplicationBundle:product:exportProductData.xlsx.twig', [
            'products' => $products,
        ]);
    }

    //product new js

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function addNewProductJSAction(Request $request)
    {
       //get string from product form json
       $productString = $request->query->get('purchaseDetails');
       $product = new Product();

       //get last productId in database
       $em = $this->getDoctrine()->getManager();
           
       $entityRepository = $this->getDoctrine()->getRepository('AppApplicationBundle:Product');
       
       $query = $entityRepository->createQueryBuilder('alias')
               ->select('alias.id')
               ->setMaxResults(1)
               ->orderBy('alias.id','DESC')
               ->getQuery();
       $result = $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
       $currDate = date('Y-m-d');
       $entityRepo = $this->getDoctrine()->getManager()->getRepository('AppApplicationBundle:Product')->findOneBy(array('id'=> $result));


       if($result != null){
        if($entityRepo->getName() == $productString[0] && $entityRepo->getCapital() == $productString[2] &&
        $entityRepo->getPrice() == $productString[3] && $productString[5] == 'fail' ){
            return new JsonResponse(array('message' =>  'fail'), 400);
        }else{
            if($result == ""){
                $result = '';
            }
            
 
            if($result != ''){
               //to get last index product 
               $lastIndexProductNo = substr($entityRepo->getProductId(),6);
 
               //* get number result id
               $numberValueId = '';
               for($no=0;$no<4;$no++){
                if($lastIndexProductNo[$no] != 0){
                    $numberValueId = $numberValueId.$lastIndexProductNo;
                } 
               }
               $numberValueId++;
               $nullValueId = '';
               for($x=0;$x<(4-strlen($numberValueId));$x++){
                    $nullValueId = $nullValueId.'0';
               };
               $newIdProduct = $nullValueId.$numberValueId;
            }else{
              $newIdProduct = '0031';
            }
 
            //get current type of product and set the status
            $listProductType = ["Dress"=>"01","Long Dress"=>"02","Mini Dress"=>"03","Short Pants"=>"04","Pants"=>"05"];
            $idStatusProduct = $listProductType[$productString[1]];
            $newProductId = substr($currDate,2,2).substr($currDate,5,2).$idStatusProduct.$newIdProduct;
            
            $product->setName($productString[0]);
            $product->setProductId($newProductId);
            $product->setTransactionId("0");
            $product->setTransId("0");
            $product->setPrice($productString[3]);       
            $product->setCustomerid('000');
    
            $product->setSellPrice('0');       
    
            $product->setCapital($productString[2]);
            $product->setStatus($productString[4]);
            $product->setType($productString[1]);
            $product->setSellDate(new \DateTime($currDate));
            $product->setDate(new \DateTime($currDate));
    
            $em->persist($product);
            $em->flush($product);
 
               return new JsonResponse(array('message' =>  $numberValueId), 200);
        } 
       }
      
    }

    public function editFormNewProductJsAction(Request $request)
    {
        //get string from product form json
        $productId = $request->query->get('productId');
        $product = new Product();
        
        $em = $this->getDoctrine()->getManager();


        $products = $em->getRepository('AppApplicationBundle:Product')->find($productId);

        $produtFieldEdit = [$products->getProductId(), $products->getName(), $products->getType(), $products->getCapital(), $products->getPrice(), $products->getStatus()];
        
        return new JsonResponse(array('message' => $produtFieldEdit ), 200);

    }

    public function editSubmitFormProductJsAction(Request $request)
    {
        //get string from product form json
        $productListField = $request->query->get('productListField');
        
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppApplicationBundle:Product')->findOneBy(['productId' => $productListField[0]] );
        $products->setName($productListField[1]);
        $products->setType($productListField[2]);
        $products->setCapital($productListField[3]);
        $products->setPrice(900000);
        $products->setStatus($productListField[5]);

        $em->persist($products);
        $em->flush($products); 


        return new JsonResponse(array('message' =>  $productListField), 200);

    }

    public function deleteProductJsAction(Request $request)
    {
        $productId = $request->query->get('productId');

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppApplicationBundle:Product')->find($productId);

        
        $em->remove($products);
        $em->flush();
        
        return new JsonResponse(array('message' =>  'sucess'), 200);
    }

     /**
     * Lists all product entities.
     *
     */
    public function testJsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppApplicationBundle:Product')->findAll();
        
        return $this->render('AppApplicationBundle:Product:testJs.html.twig', array(
            'products' => $products,
        ));
    }

    public function behaviourTestJSAction(Request $request)
    {
        //get string from product form json
        $productString = $request->query->get('purchaseDetails');
        $product = new Product();

        //get last productId in database
        $em = $this->getDoctrine()->getManager();
            
        $entityRepository = $this->getDoctrine()->getRepository('AppApplicationBundle:Product');
        
        $query = $entityRepository->createQueryBuilder('alias')
                ->select('alias.id')
                ->setMaxResults(1)
                ->orderBy('alias.id','DESC')
                ->getQuery();
        $result = $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $currDate = date('Y-m-d');
        $entityRepo = $this->getDoctrine()->getManager()->getRepository('AppApplicationBundle:Product')->findOneBy(array('id'=> $result));

      
        if(is_null($result)){
            $newIdProduct = '0001';
        }else{
            if($entityRepo->getName() == $productString[0] && $entityRepo->getCapital() == $productString[2] &&
            $entityRepo->getPrice() == $productString[3] && $productString[5] == 'fail' ){
                return new JsonResponse(array('message' =>  'fail'), 400);
            }else{
                //to get last index product 
                $lastIndexProductNo = substr($entityRepo->getProductId(),6);
    
                //* get number result id
                $numberValueId = '';
                for($no=0;$no<4;$no++){
                    if($lastIndexProductNo[$no] != 0){
                        $numberValueId = $numberValueId.$lastIndexProductNo;
                    } 
                }
                $numberValueId++;
                $nullValueId = '';
                for($x=0;$x<(4-strlen($numberValueId));$x++){
                    $nullValueId = $nullValueId.'0';
                };
                $newIdProduct = $nullValueId.$numberValueId;
            }
        }
        
          //get current type of product and set the status
           $listProductType = ["Dress"=>"01","Long Dress"=>"02","Mini Dress"=>"03","Short Pants"=>"04","Pants"=>"05"];
            $idStatusProduct = $listProductType[$productString[1]];
            $newProductId = substr($currDate,2,2).substr($currDate,5,2).$idStatusProduct.$newIdProduct;
            
            $product->setName($productString[0]);
            $product->setProductId($newProductId);
            $product->setTransactionId("0");
            $product->setTransId("0");
            $product->setPrice($productString[3]);       
            $product->setCustomerid('000');
    
            $product->setSellPrice('0');       
    
            $product->setCapital($productString[2]);
            $product->setStatus($productString[4]);
            $product->setType($productString[1]);
            $product->setSellDate(new \DateTime($currDate));
            $product->setDate(new \DateTime($currDate));
    
            $em->persist($product);
            $em->flush($product); 

            return new JsonResponse(array('message' =>  $newIdProduct), 200);
        
      

    	
    	
    }

}
