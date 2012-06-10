<?php
namespace Soap\Controller;

use Zend\Mvc\Controller\ActionController as ZendController;

class SoapController extends ZendController
{
    public function indexAction()
    {
            $soap = $this->locator->get('soapServer');
            $soap->setClass('Infosyspro\SoapServer\SoapServer',array('locator' =>$this->locator));
            $soap->handle();
            
    //$client = new Zend_Soap_Client($wsdl, array('login' => $username, 'password' => $password));
                
        return $this->getResponse();
    }
}
