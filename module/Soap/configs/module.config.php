<?php

return array(  
    'di' => array(
        'instance' => array(
            'alias' => array(
                'soap-server' => 'Soap\Controller\SoapController',               
               
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


