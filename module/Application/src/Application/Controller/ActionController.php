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

namespace Application\Controller ;

use Zend\Mvc\Controller\ActionController as ZendActionController ,
    Zend\Mvc\MvcEvent ,
    Application\View\Helper\BlockCount ,
    Application\View\Helper\Layout ,
    \Infosyspro\InfosysproLib ;

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

    protected $company ;
    protected $table ;
    protected $config ;
    protected $setUp ;
    protected $layoutParams = array ( ) ;
    protected $menuid ;

    public function execute ( MvcEvent $e )
    {

	$routeMatch = $e->getRouteMatch () ;
	if ( !$routeMatch ) {
	    /**
	     * @todo Determine requirements for when route match is missing.
	     *       Potentially allow pulling directly from request metadata?
	     */
	    throw new \DomainException ( 'Missing route matches; unsure how to retrieve action' ) ;
	}

	$action = $routeMatch->getParam ( 'action' , 'not-found' ) ;
	$controller = $routeMatch->getParam ( 'controller' , 'index' ) ;
	$id = $routeMatch->getParam ( 'id' , '' ) ;
	//$method = static::getMethodFromAction($action);
	// var_dump($routeMatch); exit;
	//Get the matched route name. this is maybe used for routing blogs, news.rss etc  
	$dynamicAction = $routeMatch->getMatchedRouteName () ;
	if ( $dynamicAction != 'default' ) {
	    $controller = strtolower (
		    rtrim (
			    array_pop (
				    explode ( '\\' , $controller )
			    ) , 'Controller' )
	    ) ;
	}
	if ( $id ) {
	    $action = $id ;
	    if ( $action == lcfirst ( 'index' ) ) {
		$method = static::getMethodFromAction ( $action ) ;
	    } else {
		$method = '_renderContent' ;
	    }
	} else {
	    $method = static::getMethodFromAction ( $action ) ;
	}

	if ( !method_exists ( $this , $method ) ) {
	    $method = 'notFoundAction' ;
	}

	$this->menuid = lcfirst ( $controller ) . ucfirst ( str_replace ( array ( '.html' , '-' , '_' ) , '' , $action ) ) ;

	$this->setView () ;

	if ( $id && $action != 'index' ) {
	    $actionResponse = $this->$method ( str_replace ( array ( '.html' , '-' , '_' ) , '' , $action ) ) ;
	} else {
	    $actionResponse = $this->$method () ;
	}

	if ( !method_exists ( $this , $method ) ) {
	    $method = 'notFoundAction' ;
	}

	$e->setResult ( $actionResponse ) ;
	return $actionResponse ;
    }

    protected function setView ()
    {

	//$this->company = $this->locator->get('companylib');   
	// $this->view->plugin('doctype')->setDoctype('HTML5');
	$serviceLocator = $this->getServiceLocator () ;

	$this->company = new InfosysproLib ( $serviceLocator ) ;
	$config = $this->company->getConfig () ;


	$where = array ( 'where' => array ( 'moduleName' => 'template' ) ,
	    'orWhere' => array ( 'moduleName' => 'site' ) ,
	) ;
	//var_dump($config->loadDbConfig($where)); exit;

	$this->layoutParams['config'] = $config->loadDbConfig ( $where ) ;

	$this->layoutParams['template'] = $this->layoutParams['config']->template ;
	$this->layoutParams['template']->moduleCount = BlockCount::countBocks ($this->company->getAdapter() , $this->menuid ) ;
	// var_dump($this->layoutParams['template']->moduleCount); exit;
	$this->layoutParams['template']->menuid = $this->menuid ;
	unset ( $this->layoutParams['config']->template ) ;
	$this->layoutParams['lang'] = $serviceLocator->get ( 'translator' ) ;
	$this->layoutParams['currentlang'] = $this->layoutParams['lang']->getLocale () ;
	$tempSetUp = new Layout ( $this->layoutParams['template'] ) ;
	//$this->setUp = $tempSetUp->toArray(); 
	$this->layoutParams['setUp'] = $tempSetUp->toArray () ;
	$this->init () ;
    }

    protected function init ()
    {
	
    }

}

