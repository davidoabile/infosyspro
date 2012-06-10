<?php

return array(
    'di' =>
    array(
        'instance' =>
        array(
            
            'Db' =>
            array(
                'parameters' =>
                array(
                    'driver' =>
                    array(
                        'driver' => 'Pdo',
                        'dsn' => 'mysql:host=localhost;dbname=admin_ultrafast',
                        'dbname' => 'admin_ultrafast',
                        'hostname' => 'localhost',
                        'username' => 'cli_ultrafast',
                        'password' => 'testtestt',
                        'driver_options' =>
                        array(
                            1002 => 'SET NAMES \'UTF8\'',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
