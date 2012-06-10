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

 namespace Cms\Controller;

use Zend\Mvc\Controller\ActionController as ZendActionController,
    Zend\Mvc\MvcEvent,    
      // Zend\View\Resolver as Resolver,
      //  Zend\View\Renderer\PhpRenderer as PhpRenderer,
    Infosyspro\Listeners as CompanyListeners;

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
         parent::execute($e);
        
          
      }
     protected function setView()
     {   

         $this->view = $this->locator->get('view');
         $this->company = $this->locator->get('companylib');   
         $this->company->setHeadLink('appendStylesheet', array('/media/cms/css/template.css'));
         $this->company->setHeadLink('appendStylesheet', array('/media/cms/css/system.css'));      
        
        // $this->company->setHeadScript('appendFile', array('/media/cms/js/mootools-more.js',));         
         $this->view->plugin('doctype')->setDoctype('HTML5');
         
         $this->init();
     }

     protected function init()
     {
         
     }

 }

 