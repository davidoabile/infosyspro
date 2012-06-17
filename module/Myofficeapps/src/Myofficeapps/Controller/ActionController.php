<?php

 /**
  * Infosyspro Framework
  *
  * LICENSE
  *
  * This source file is subject to the new BSD license that is bundled
  * with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * http://infosyspro.com/license
  * If you did not receive a copy of the license and are unable to
  * obtain it through the world-wide-web, please send an email
  * to support@infosyspro.com so we can send you a copy immediately.
  *
  * @category   Infosys
  * @package    Infosys_DB
  * @subpackage Adapter
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 /**
  * @namespace
  */

 namespace Myofficeapps\Controller;

use Zend\Mvc\Controller\RestfulController as ZendActionController,
    Zend\Mvc\MvcEvent,    
    Infosyspro\InfosysproLib ;

 /**
  * Class for connecting to SQL databases and performing common operations.
  *
  * @uses       \Zend\Db\Db 
  * @category   Zend
  * @package    Zend_Db
  * @subpackage Adapter
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 abstract class ActionController extends ZendActionController
 {
    
     //protected $view;
     protected $company;
     protected $table;
     
    
    public function execute(MvcEvent $e)
    {
	 $this->setView();
        $routeMatch = $e->getRouteMatch();
        if (!$routeMatch) {
            /**
             * @todo Determine requirements for when route match is missing.
             *       Potentially allow pulling directly from request metadata?
             */
            throw new \DomainException('Missing route matches; unsure how to retrieve action');
        }

        $request = $e->getRequest();
       // die($request->getMethod());
        $action  = $routeMatch->getParam('action', false);
	
        if ($action && $action !== 'api') {
	// Handle arbitrary methods, ending in Action
            $method = static::getMethodFromAction($action);
            if (!method_exists($this, $method)) {
                $method = 'notFoundAction';
            }
            $return = $this->$method();
        } else {
	    
        	$data = $request->query()->toArray();
		//var_dump($data); exit;
            // RESTful methods
            switch (strtolower($request->getMethod())) {
                case 'get':
                    if (null !== $id = $routeMatch->getParam('id')) {
                        $return = $this->get($id,$data);
                        break;
                    }
                    if (null !== $id = $request->query()->get('id')) {
                        $return = $this->get($id, $data);
                        break;
                    }
                    $return = $this->getList($data);
                    break;
                case 'post':		    
                    $return = $this->create($request->post()->toArray());                    
                    break;
                case 'put':					
                	if (null === $id = $routeMatch->getParam('id') && empty($data['dc'])) {
                        if (!($id = $request->query()->get('id', false))) {
                            throw new \DomainException('Missing identifier');
                        }
                    }
                    $content = $request->getContent();
                    parse_str($content, $parsedParams);
                    $return = $this->update($id, $parsedParams);
                    break;
                case 'delete':
		    $content = $request->getContent();
                    parse_str($content, $data);
                	
                    if (null === $id = $routeMatch->getParam('id') && empty($data['dc'])) {
                        if (!($id = $request->query()->get('id', false))) {
                            throw new \DomainException('Missing identifier');
                        }
                    }
                    $return = $this->delete($id, $data);
                    break;
                default:
                    throw new \DomainException('Invalid HTTP method!');
            }
        }

        // Emit post-dispatch signal, passing:
        // - return from method, request, response
        // If a listener returns a response object, return it immediately
        $e->setResult($return);
        return $return;
    }
    
    
     protected function setView()
     {   
         if(null == $this->company ) {
            $serviceLocator = $this->getServiceLocator () ;
            $this->company = new InfosysproLib ( $serviceLocator ) ;
         }
         
         $this->company->setHeadLink('appendStylesheet', array('/media/cms/css/template.css'));
         $this->company->setHeadLink('appendStylesheet', array('/media/cms/css/system.css'));      
   
         $this->init();
     }

     protected function init()
     {
         
     }

 }

 