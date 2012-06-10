<?php
/*
return array(
    'layout' => 'layouts/layout.phtml',
    'di' => array(
        'instance' => array(
            'alias' => array(
                'index' => 'Application\Controller\IndexController',
                'error' => 'Application\Controller\ErrorController',
                'blog' => 'Application\Controller\BlogController',
                'view' => 'Zend\View\Renderer\PhpRenderer',
                'DbSelect' => 'Zend\Db\Sql\Select',
                'Db' => 'Zend\Db\Adapter\Adapter',   
                'companylib' => 'Infosyspro\InfosysproLib',
                'broker' => 'Zend\View\HelperLoader',
                'userManager' => 'Infosyspro\User\UserManager',
                'sessionManager' => 'Infosyspro\Session\SessionManager',
                'userSessionManager' => 'Infosyspro\Session\UserSessionManager',
                'aclManager' => 'Infosyspro\Acl\AclManager',
                'Dbtable' => 'Application\Model\RowTable',                
                'table' => 'Zend\Db\Adapter\Adapter',
                'appConfig' => 'Infosyspro\Config\ModuleConfig',
                'mail' => 'Infosyspro\Mail\Mail',
                'soapServer' => 'Zend\Soap\Server',
                'soapClient' => 'Zend\Soap\Client',                
                'translator' => 'Infosyspro\Translator\Translator',
            ),
            'companylib' => array(
                'parameters' => array('instance' => 'Zend\Mvc\Application',),
            ),
            'userSessionManager' => array(
                'parameters' => array(
                    'db' => 'Db',
                ),
            ),
            'aclManager' => array(
                'parameters' => array('acl' => 'Zend\Acl\Acl',
                    'roleAdapter' => 'Company\Acl\AclAdapter',
                ),
            ),
            'appConfig' => array(
                'parameters' => array('adapter' => 'Db',),
            ),
            'mail' => array(
                'parameters' => array('configInstance' => 'appConfig',),
            ),
            'Dbtable' => array('parameters' => array( 'name' => 'TbContent', 
                    'adapter' => 'Db',
                ),
            ),
            'table' => array('parameters' => array(
                    'adapter' => 'Db',
                ),
            ),
            
            'Company\Acl\AclAdapter' => array(
                'parameters' => array('dbAdapter' => 'Dbtable'),
            ),
            'soapServer' => array('parameters' => array('wsdl' => null,
                    'options' => array('uri' => 'http://saas.development/soap-server'),
                ),
            ),
            'soapClient' => array('parameters' => array('options' => array(
                        'location' => 'http://saas.development/soap-server',
                        'uri' => 'http://saas.development/soap-server',
                    ),
                )
            ),
            'translator' => array(
                'parameters' => array('options' => array(
                        'adapter' => 'tmx',
                        'content' => COMPANY_PATH . '/languages/translation.tmx',
                        'locale' => 'en',
                    ),
                ),
            ),
    
            // Injecting the plugin broker for controller plugins into
// the action controller for use by all controllers that
// extend it
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker' => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),
            // Setup for router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        
                        'default' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route' => '/[:controller[/:action]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'Application\Controller\IndexController',
                                    'action' => 'index',
                                ),
                            ),
                        ),
                      
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route' => '/',
                                'defaults' => array(
                                    'controller' => 'Application\Controller\IndexController',
                                    'action' => 'index',
                                ),
                            ),
                        ),
                          'blog' => array(
                            'type' => 'Zend\Mvc\Router\Http\Regex',
                              'options' => array(
                            'regex' => '/blog/(?<id>[a-zA-Z0-9_-]+)(\.(?<format>(json|html|xml|rss)))?',
                             'defaults' => array(
                                    'controller' => 'Application\Controller\BlogController',
                                   'format' => 'html',
                                ),
                               'spec' => '/blog/%id%.%format%',
                            ),
                      ),
                        
                        
                    ),
                ),
            ),
            // Setup for the view layer.
// Using the PhpRenderer, which just handles html produced by php
// scripts
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),
            // Defining how the view scripts should be resolved by stacking up
// a Zend\View\Resolver\TemplateMapResolver and a
// Zend\View\Resolver\TemplatePathStack
            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplateMapResolver',
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),
            // Defining where the layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map' => array(
                        'layout/layout' => __DIR__ . '/../views/layouts/layout.phtml',
                        'layout/errorlayout' => __DIR__ . '/../views/layouts/error.phtml',
                    ),
                ),
            ),
            // Defining where to look for views. This works with multiple paths,
// very similar to include_path
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths' => array(
                        'application' => __DIR__ . '/../views',
                    ),
                ),
            ),
            // View for the layout
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/layout',
                ),
            ),
            // Injecting the router into the url helper
            'Zend\View\Helper\Url' => array(
                'parameters' => array(
                    'router' => 'Zend\Mvc\Router\RouteStack',
                ),
            ),
            // Configuration for the doctype helper
            'Zend\View\Helper\Doctype' => array(
                'parameters' => array(
                    'doctype' => 'HTML5',
                ),
            ),
            // View script rendered in case of 404 exception
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions' => true,
                    'notFoundTemplate' => 'error/404',
                ),
            ),
            // View script rendered in case of other exceptions
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate' => 'error/index',
                    'layoutTemplate' => 'layout/error',
                ),
            ),
        ),
    ),
);
 * 
 */


return array(
     'di' => array(
        'instance' => array(
            'alias' => array(               
                'soapServer' => 'Zend\Soap\Server',
                'soapClient' => 'Zend\Soap\Client',                
                'translator' => 'Infosyspro\Translator\Translator',
            ),
           
            'mail' => array(
                'parameters' => array('configInstance' => 'appConfig',),
            ),
           
            'soapServer' => array('parameters' => array('wsdl' => null,
                    'options' => array('uri' => 'http://saas.development/soap-server'),
                ),
            ),
            'soapClient' => array('parameters' => array('options' => array(
                        'location' => 'http://saas.development/soap-server',
                        'uri' => 'http://saas.development/soap-server',
                    ),
                )
            ),
            'translator' => array(
                'parameters' => array('options' => array(
                        'adapter' => 'tmx',
                        'content' => COMPANY_PATH . '/languages/translation.tmx',
                        'locale' => 'en',
                    ),
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'default' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/[:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'index',
                        'action' => 'index',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controller' => array(
        'classes' => array(
            'index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'index/index' => __DIR__ . '/../view/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);


