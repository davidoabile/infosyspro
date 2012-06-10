<?php

return array(
    'controller' => array(
        'classes' => array(
            'cms/cms' => 'Cms\Controller\CmsController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cms' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cms[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'cms/cms',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
   
     
);

