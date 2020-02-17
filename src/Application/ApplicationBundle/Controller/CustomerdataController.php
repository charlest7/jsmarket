<?php

namespace Application\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\ApplicationBundle\Entity\Customer;
use Application\ApplicationBundle\Entity\Custdata;
use Symfony\Component\HttpFoundation\Request;
use Application\ApplicationBundle\Entity\Product;
use Application\ApplicationBundle\Entity\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\ApplicationBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class CustomerdataController extends Controller
{

     /**
     * Lists all application entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('AppApplicationBundle:Custdata')->findAll();

        return $this->render('AppApplicationBundle:Customerdata:index.html.twig', array(
            'customers' => $customers,
        ));
    }


    public function collectCustomerDataAction(Request $request){
        $userEmail = $request->query->get('customerData');
        
        return new JsonResponse(array('message' => $userEmail), 200);
    }

    public function collectCustDataAction(Request $request){
        $customerData = $request->query->get('customerData');
        
        $encCustData = utf8_encode($customerData); // Don't forget the encoding
        $custData = json_decode($encCustData);

        $em = $this->getDoctrine()->getManager();

        //function to check email or phone are not register to customer entity data
        $customerEntity = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('email'=> $custData->email));
        $statusCustData = '';
        $status = '';
        $statusM = 'an';

        
        if($customerEntity != null && $custData->email != ''){
            //$statusCustData =  $this->checkSecondaryEntity($custData);
            $statusCustData = $this->checkSecondaryEntity($custData);

            if(count($statusCustData) > 0){
                if(!in_array('cookieId', $statusCustData) || !in_array('ipAddress', $statusCustData) ){
                    $statusCustData = $this->createNewEntityCustomerData($custData);
                    $statusM = "Generate new entity Data with different Cookie, Email available in CE";
                }else{
                    $statusCustData = false;
                    $statusM = "entity data has been existed";
                }
            }


        }else{
            $statusCustData = $this->checkSecondaryEntity($custData);
            
            if(count($statusCustData) > 0 && $custData->email !=''){

                if(in_array('cookieId', $statusCustData) && in_array('ipAddress', $statusCustData)){
                    $statusCustData = $this->saveDataEntitySameIPandCookieId($custData);
                    $statusM = "Same IP & Cookie, but Email is not Exist in CE -> Add Email to the existing CE";
                }else if(in_array('cookieId', $statusCustData) && !in_array('ipAddress', $statusCustData)){
                    $statusCustData = $this->saveDataSameCookieBlankCustomerEmail($custData);
                    $statusM = "Same Cookie, Different IP,but Email is not Exist  -> Add Email to the Existing CE ";
                }else{
                    $statusCustData = false;
                    $statusM = 'false';
                }


            }else{
                $statusCustData = $this->createNewEntityCustomerData($custData);
                if($statusCustData == true){
                    $statusCustData = "Create New";

                }
                $statusM = "bener";
               
            }

            $status = $statusCustData;
        }

        return new JsonResponse(array('message' => $statusM), 200);
    }

    public function saveDataSameCookieBlankCustomerEmail($customerData){
        $em = $this->getDoctrine()->getManager();

        $cookieEntity = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('email'=>'','cookieId'=> $customerData->cookie));
        
        $status = $this->createNewEntityCustomerData($customerData);;
        if($cookieEntity != null){
            $cookieEntity->setEmail($customerData->email);
            $cookieEntity->setGoogleAnalyticsUserId(hash("sha256", $customerData->email));
            


            $em->persist($cookieEntity);
            $em->flush();

        }else{

            $status = false;
        }

        return $status;

    }

    public function checkSecondaryEntity($customerData){
        $similarCustDataEntity = [];
        $em = $this->getDoctrine()->getManager();

        if($customerData->cookie != ''){
            $cookieEntity = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('cookieId'=> $customerData->cookie));
            if($cookieEntity != null){
                array_push($similarCustDataEntity, 'cookieId');
            }    
        }

        if($customerData->ipAddress != ''){
            $ipAdrressEntity = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('ipAddress'=> $customerData->ipAddress));
            if($ipAdrressEntity != null){
                array_push($similarCustDataEntity, 'ipAddress');

                
            }    
        }



        return $similarCustDataEntity;

    }

    public function determineChangedOfSecondaryCustomerData($customerData, $statusCustomerData)
    {

    }

    public function saveDataEntitySameIPandCookieId($customerData)
    {
        $em = $this->getDoctrine()->getManager();
        $custData = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('email'=>'','cookieId'=> $customerData->cookie,'ipAddress'=> $customerData->ipAddress));
        
        $status = false;
        if($custData!= null){
            $custData->setEmail($customerData->email);
            $custData->setGoogleAnalyticsUserId(hash("sha256", $customerData->email));

            $em->persist($custData);
            $em->flush();
            $status = true;
        }else{
            $status = $this->createNewEntityCustomerData($customerData);
        }
        return $status;
    }

    public function createNewEntityCustomerData($customerData){
        $em = $this->getDoctrine()->getManager();
        $custData = new Custdata();

        $custData->setPhone("");
        $custData->setEmail($customerData->email);
        $custData->setIpAddress($customerData->ipAddress);
        $custData->setCookieId($customerData->cookie);
        $custData->setAction("Screen Tracking Apps");
        $custData->setGoogleAnalyticsUserId("");
        $custData->setSalesforceUserId("");
        $custData->setIpentity($customerData->ipEntity);
        $custData->setDeviceId($customerData->guid);

        $emailVal = "";
        if($customerData->email != ""){
            $emailVal = hash("sha256", $customerData->email);
        }

        $custData->setGoogleAnalyticsUserId($emailVal);


        $em->persist($custData);
        $em->flush();

        return true;

    }

    public function getPublicEntityAction(Request $request){
        $idCustomerEntity = $request->query->get('idCustomerEntity');
        $em = $this->getDoctrine()->getManager();
        $custData = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('id'=>$idCustomerEntity));
        
        return new JsonResponse(array('message' => $custData->getIpentity()), 200);
    }

    public function getUserIdHashAction(Request $request){
        $userId = $request->query->get('userId');
        return new JsonResponse(array('message' => hash("sha256", $userId)), 200);

    }

    public function getDetailsEntityAction(Request $request){
        $idCustomerEntity = $request->query->get('idCustomerEntity');
        $em = $this->getDoctrine()->getManager();
        $custData = $em->getRepository('AppApplicationBundle:Custdata')->findOneBy(array('id'=>$idCustomerEntity));
        
        $detailsEntity = [
            $custData->getPhone(),
            $custData->getEmail(),
            $custData->getIpAddress(),
            $custData->getCookieId(),
            $custData->getAction(),
            $custData->getGoogleAnalyticsUserId(),
            $custData->getSalesforceUserId(),
            $custData->getIpentity(),
            $custData->getDeviceId(),
            $custData->getGoogleAnalyticsUserId()

        ];
        return new JsonResponse(array('message' => $detailsEntity), 200);

    }


}
