<?php

namespace Application;

use Zend\Db\Adapter\Adapter as DbAdapter,
        Zend\EventManager\StaticEventManager;

class Module {

    protected $view;
    protected $viewListener;

    /*   public function init(Manager $moduleManager) {

      $events = StaticEventManager::getInstance();
      $events->attach('bootstrap', 'bootstrap', array($this, 'initializeView'));
      }
     */

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
                     $session = new \Infosyspro\Session\SessionManager ();
                     return $session;
                 }
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function initializeView($e) {

       
        $app = $e->getApplication();

        $requestUri = $app->getRequest()->getRequestUri();
        $basePath = $app->getRequest()->getBasePath();
        $sm = $app->getServiceManager();
        $config = $sm->get('config');
       // $view = $this->getView($app);
         $view = $sm->get('viewrenderer');
        $view->plugin('basePath')->setBasePath($basePath);
        $browser = @get_browser(null, true);

        if (!empty($browser['ismobiledevice'])) {

            $tpl = $locator->get('Zend\View\Resolver\TemplateMapResolver');
            $map = array(
                'layout/layout' => __DIR__ . '/views/layouts/mobile.phtml',
                'layout/errorlayout' => __DIR__ . '/views/layouts/errorMobile.phtml',
            );

            $tpl->setMap($map);

            $viewPath = $tpl = $locator->get('Zend\View\Resolver\TemplatePathStack');
            $path = array(
                'application' => __DIR__ . '/mobile',
            );
            $viewPath->setPaths($path);
            unset($tpl);
            unset($map);
            unset($viewPath);
            unset($path);
        } elseif (1 === strpos($requestUri, 'cms', 1) && empty($browser['ismobiledevice'])) {

            $tpl =  new \Zend\View\Resolver\TemplateMapResolver;
            $map = array(
                'layout/layout' => __DIR__ . '/views/layouts/cms.phtml',
                'layout/errorlayout' => __DIR__ . '/views/layouts/error.phtml',
            );

            $tpl->setMap($map);
            unset($tpl);
            unset($map);
        } else {

           
         /*   $viewListener = $this->getViewListener($view, 'layout/layout');
            $app->events()->attachAggregate($viewListener);
            $events = StaticEventManager::getInstance();
            $viewListener->registerStaticListeners($events, $sm);
          * 
          */
        }

        $sessionManager = $sm->get('session');
        $sessionManager->setName('infosysApp');
        $sessionManager->start();
    }

    protected function getViewListener($view, $layout) {
        // if()
        if ($this->viewListener instanceof View\Listener) {
            return $this->viewListener;
        }

        $viewListener = new View\Listener($view, $layout);
        $viewListener->setDisplayExceptionsFlag(true);

        $this->viewListener = $viewListener;
        return $viewListener;
    }

    protected function getView($app) {
        if ($this->view) {
            return $this->view;
        }

        $di = $app->getLocator();
        $view = $di->get('view');
        $url = $view->plugin('url');
        $url->setRouter($app->getRouter());

        $this->view = $view;
        return $view;
    }

}
