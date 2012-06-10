<?php
return array (
  'di' => 
  array (
    'instance' => 
    array (
      'alias' => 
      array (
        'Db' => 'Zend\\Db\\Adapter\\Adapter',
      ),
      'Db' => 
      array (
        'parameters' => 
        array (
          'driver' => 
          array (
            'driver' => 'Pdo',
            'dsn' => 'mysql:dbname=admin_infosys;hostname=localhost',
            'username' => 'company_infosys',
            'password' => 'dailer00',
            'driver_options' => 
            array (
              1002 => 'SET NAMES \'UTF8\'',
            ),
          ),
        ),
      ),
    ),
  ),
);
