<?php

return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'cms' => 'Cms\Controller\CmsController',                
                'cmsHelper' => 'Cms\View\Helper\CmsHelper',
            ),     
    ),
        ),
);


// published environments
$production = $default;
$staging = $default;
$testing = $default;
$development = $default;
$config = compact('production', 'staging', 'testing', 'development');

return $config;


