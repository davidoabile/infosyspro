<?php

date_default_timezone_set('Australia/Brisbane');
if(!defined('COMPANY_PATH')) {
    define('COMPANY_PATH', __DIR__);
}

if(!defined('COMPANY_NAME')) {
   define('COMPANY_NAME' , 'core' ); 
}

chdir(dirname(__DIR__));
require_once (getenv('ZF2_PATH') ?: 'vendor') . '/Zend/Loader/AutoloaderFactory.php';
define('APPLICATION_PATH', dirname(__DIR__));
define('APPLICATIN_MODULE_PATH', dirname(__DIR__) . '/modules');

use Zend\Loader\AutoloaderFactory,
Zend\ServiceManager\ServiceManager,
Zend\Mvc\Service\ServiceManagerConfiguration;

// setup autoloader
//AutoloaderFactory::factory();
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array(
    'namespaces' => array(       
        'Infosyspro' => dirname(__DIR__) . '/vendor/Infosyspro',
    )
)));
 
 

// get application stack configuration
$configuration = include 'config/application.config.php';

// setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($configuration['service_manager']));
$serviceManager->setService('ApplicationConfiguration', $configuration);
$serviceManager->get('ModuleManager')->loadModules();

// run application
$serviceManager->get('Application')->bootstrap()->run()->send();