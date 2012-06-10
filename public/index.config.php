<?php
define('COMPANY_PATH', __DIR__);
chdir(dirname(__DIR__) .'/../');
date_default_timezone_set('Australia/Brisbane');

require_once (getenv('ZF2_PATH') ?: 'vendor') . '/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array(
    'namespaces' => array(
        'Company' => dirname(__DIR__) . '/../vendor/Company',
        'Infosyspro' => dirname(__DIR__) . '/../vendor/Infosyspro',
    )
)));

$company = getenv("COMPANY");

$appConfig = include 'config/application.config.php';

$listenerOptions = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath("config/autoload/{,*.}{global,$company}.config.php");
    

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

// Create application, bootstrap, and run
$bootstrap = new Zend\Mvc\Bootstrap($defaultListeners->getConfigListener()->getMergedConfig());
$application = new Zend\Mvc\Application;
$bootstrap->bootstrap($application);
$application->run()->send();
