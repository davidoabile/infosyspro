<?php

namespace Soap;

use Zend\Module\Manager,
    Zend\Config\Config,
    Zend\EventManager\StaticEventManager,
    Zend\Loader\AutoloaderFactory,
    Zend\Module\Consumer\AutoloaderProvider;


class Module implements AutoloaderProvider
{
    
    public function init()
    {        
        $events = StaticEventManager::getInstance();      
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

  

    public function getConfig($env = null)
    {
       $config = new Config(
            include __DIR__ . '/configs/module.config.php'
        );         
     
        return $config;
    }
    
    
}
