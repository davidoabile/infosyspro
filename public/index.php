<?php
/*define('COMPANY_PATH', __DIR__);
chdir(dirname(__DIR__));
date_default_timezone_set('Australia/Brisbane');
//date_default_timezone_set(date_default_timezone_get());
define('APPLICATION_PATH', dirname(__DIR__));
define('APPLICATIN_MODULE_PATH', dirname(__DIR__) . '/modules');
require_once (getenv('ZF2_PATH') ?: 'vendor/') . '/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array(
    'namespaces' => array(
        'Company' => dirname(__DIR__) . '/vendor/Company',
        'Infosyspro' => dirname(__DIR__) . '/vendor/Infosyspro',
    )
)));


$appConfig = include 'config/application.config.php';

$listenerOptions = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath("config/autoload/{,*.}{global,local}.config.php");
    

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

// Create application, bootstrap, and run
$bootstrap = new Zend\Mvc\Bootstrap($defaultListeners->getConfigListener()->getMergedConfig());
$application = new Zend\Mvc\Application;
$bootstrap->bootstrap($application);
$application->run()->send();
 * 
 */
date_default_timezone_set('Australia/Brisbane');
define('COMPANY_PATH', __DIR__);
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