<?php

return array(
    'controller' => array(
        'classes' => array(
            'myofficeapps/myofficeapps' => 'Myofficeapps\Controller\MyofficeappsController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'myofficeapps' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/myofficeapps[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'myofficeapps/myofficeapps',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
   
     
);

