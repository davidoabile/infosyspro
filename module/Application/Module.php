<?php
/**
 * InfosysPro
 *
 * LICENSE
 *
 * This source file is subject to the Infosyspro license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://infosyspro.com.au/license/software
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@infosyspro.com so we can send you a copy immediately.
 *
 * @category   Module
 * @package    Application_Module
 * @subpackage Module
 * @copyright  Copyright (c) 2009-2012 Infosyspro. (http://www.infosyspro.com.au)
 * @license    http://infosyspro.com.au/license/software     PRIVATE License
 */

namespace Application;

use Zend\Db\Adapter\Adapter as DbAdapter,
     Infosyspro\Mobile\Mobile;

/**
 * This is Zend core module config
 */
class Module {

    protected $view;
    protected $viewListener;

  
    public function onBootstrap($e)
    {
       $this->initializeView($e);
    }
    
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
	
    }

    /**
     * Setup service manager
     * 
     * @return void
     */
    public function getServiceConfiguration() {
        return array(
           
            'factories' => array(
                'db-adapter' => function($sm) {
                    $config = $sm->get('config')['db'];  		   
                    $dbAdapter = new DbAdapter($config);                   
                    return $dbAdapter;
                },
                 'companylib' => function ( $sm ) {
                    return new \Infosyspro\InfosysproLib($sm);
                 },
                 'appConfig' => function ( $sm ) {                  
                     return new \Infosyspro\Config\ModuleConfig( $sm->get('db-adapter') );
                 },
                 'session' => function ($sm) {
                     $session = new \Infosyspro\Session\SessionManager ('infosysApp');
                    // $session->setName('infosysApp');               
                     return $session;
                 }
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Process custom config after the bootsrap has been proccessed
     * 
     * This is where layouts are set and mobile devices are detected
     * So that views can be rendered appropriately
     * 
     * @param object $e
     */
    public function initializeView($e) {

       
        $app = $e->getApplication();
        $basePath = $app->getRequest()->getBasePath();
        $sm = $app->getServiceManager();
       // $sessionManager = $sm->get('session');
       // $sessionManager->setName('infosysApp');
        // $sessionManager->start();
        $view = $sm->get('viewrenderer');
        $view->plugin('basePath')->setBasePath($basePath);
        $device = new Mobile();
	$host = $app->getRequest()->uri();
	$requestUri = ltrim( $host->getPath(), '/');
	$url = array_shift( explode('.', $host->getHost()));

       if (($url === 'myofficeapps' || $requestUri ===  'myofficeapps') && ( $device->isTablet() || $device->getName() === null)) {
          
             $tplManger = $sm->get('ViewTemplateMapResolver');  	    
            $map = array(
                'layout/layout' => __DIR__ . '/view/layout/myofficeapps.phtml',
                'layout/errorlayout' => __DIR__ . '/view/layouts/error.phtml',
            );

            $tplManger->setMap($map);
            unset($tplManger);
            unset($map);
        } elseif ($device->isMobileDevice()) {
            $tplManger = $sm->get('ViewTemplateMapResolver');  
            $map = array(
                'layout/layout' => __DIR__ . '/view/layout/mobile.phtml',
                'layout/errorlayout' => __DIR__ . '/view/layout/errorMobile.phtml',
            );

            $tplManger->setMap($map);

            $viewPath = $sm->get('ViewTemplatePathStack');
            $path = array(
                'application' => __DIR__ . '/mobile',
            );
            $viewPath->setPaths($path);
            unset($tplManger);
            unset($map);
            unset($viewPath);
            unset($path);
            
        } 
        
    }

}