<?php

/**
 * Infosyspro Framework
 *
 * LICENSE
 *
 * This source file is subject to the new private license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://infosyspro.com/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@infosyspro.com so we can send you a copy immediately.
 *
 * @category   Infosys
 * @package    Infosys_DB
 * @subpackage Adapter
 * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
 * @license    http://infosyspro.com/license     New Infosyspro License
 * @author    David Oabile <doabile@infosyspro.com.au>
 * 
 */
/**
 * @namespace
 */

namespace Infosyspro\Config;

use Application\Model\TbConfig,
        Zend\Db\Adapter\Adapter;

/**
 * Class for connecting to SQL databases and performing common operations.
 *
 * @uses       \Zend\Db\Db 
 * @category   Zend
 * @package    Zend_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
 * @license    http://infosyspro.com/license     New Infosyspro License
 * @author    David Oabile <doabile@infosyspro.com.au>
 * 
 */
class ModuleConfig {
  
  protected $nestSeparator = '.';
  
  /**
   *
   * @var object mysql DbTable
   */
  protected $mysql = null;
  
  public function __construct( Adapter $adapter = null) {
     
      $this->mysql = new TbConfig( $adapter);
  }
 /**
     * This is used to replace some data stored in the application.ini. Columns keyValue and value should exists in the table
     *
     * Table sample ID moduleID keyValue Value description
     *
     *   CREATE  TABLE  `TbConfig` (
     *                  `id` INT NOT NULL AUTO_INCREMENT ,
     *                  `moduleName` VARCHAR(100) NOT NULL ,
     *                  `key` VARCHAR(45) NULL ,
     *                  `value` VARCHAR(100) NULL ,
     *                  `description` VARCHAR(150) NULL ,
     *                  PRIMARY KEY (`id`) )
     *                  COMMENT = 'This table holds all the configuration for the site including its modules. This replaces the local sections of the ini files';
     *
     * Use self::_processDBConfigObj($config) to get object similar to Zend_config_ini()
     * values e.g. maze.newenrol = E will be $config->maze->newenrol assuming $config= libraryName::_processDBConfigObj($config)
     * Use self::_processDBConfig($config) to get array data similar to $bootstrap->getOptions();
     * Values e.g. maze.newenrol = E will be $config['maze']['newenrol'] etc
     * @param string $sql
     * @return object
     */

    public function loadDbConfig($whereConditions = array(), $retunObject = true ) {

        $data = $this->mysql->selectRow($whereConditions);

        if (sizeof($data) > 0) {

            if ($retunObject) {
                return $this->processDbConfigObj($data);
            } else {
                return $this->processDbConfig($data);
            }
        }
        return false;
    }

    protected function processDbConfig($config) {
        $_config = array();
       foreach($config as $k=>$v ) {
         $_config = $this->processKey($_config, $v['key'] , $v['value']);
       }

     return $_config;
    }

    /**
     * Process DB->fetchAll results and pass it on for further processing
     * @param array $config
     * @return object
     */
     protected function processDbConfigObj($config) {
        $_config = new \stdClass();
       foreach($config as $k=>$v ) {
         $_config = $this->processKeyObj($_config, $v['key'] , $v['value']);
       }

     return $_config;
    }

     /**
     * Assign the key's value to the property list. Handles the
     * nest separator for sub-properties.
     *
     * @param  array  $config
     * @param  string $key
     * @param  string $value
     * @throws Zend_Config_Exception
     * @return array
     */
    protected function processKey($config, $key, $value)
    {
        if (strpos($key, $this->nestSeparator) !== false) {
            $pieces = explode($this->nestSeparator, $key, 2);         
            if (strlen($pieces[0]) && strlen($pieces[1])) {
                if (!isset($config[$pieces[0]])) {
                    if ($pieces[0] === '0' && !empty($config)) {
                        // convert the current values in $config into an array
                        $config = array($pieces[0] => $config);
                    } else {
                        $config[$pieces[0]] = array();
                    }
                } elseif (!is_array($config[$pieces[0]])) {
                    /**
                     * @see Zend_Config_Exception
                     */
                 //   require_once 'Zend/Config/Exception.php';
                    throw new \Zend\Config\Exception("Cannot create sub-key for '{$pieces[0]}' as key already exists");
                }
                $config[$pieces[0]] = $this->processKey($config[$pieces[0]], $pieces[1], $value);
            } else {
                /**
                 * @see Zend_Config_Exception
                 */
              //  require_once 'Zend/Config/Exception.php';
                throw new Zend\Config\Exception("Invalid key '$key'");
            }
        } else {
            $config[$key] = $value;
        }
        return $config;
    }


     /**
     * Assign the key's value to the property list. Handles the
     * nest separator for sub-properties.
     *
     * @param  array  $config
     * @param  string $key
     * @param  string $value
     * @throws Zend_Config_Exception
     * @return object
     */
    protected function processKeyObj($config, $key, $value)
    {
        if (strpos($key, $this->nestSeparator) !== false) {
            $pieces = explode($this->nestSeparator, $key, 2);
            if (strlen($pieces[0]) && strlen($pieces[1])) {
                if (!isset($config->$pieces[0])) {
                    if ($pieces[0] === '0' && !empty($config)) {
                        // convert the current values in $config into an array
                        $config = new \stdClass($pieces[0]= $config);
                    } else {
                        $config->{$pieces[0]} = new \stdClass();
                    }
                } elseif (!is_object ($config->$pieces[0])) {
                    /**
                     * @see Zend_Config_Exception
                     */
                 //   require_once 'Zend/Config/Exception.php';
                    throw new Zend\Config\Exception("Cannot create sub-key for '{$pieces[0]}' as key already exists");
                }
                $config->$pieces[0] = $this->processKeyObj($config->$pieces[0], $pieces[1], $value);
            } else {
                /**
                 * @see Zend_Config_Exception
                 */
              //  require_once 'Zend/Config/Exception.php';
                throw new Zend\Config\Exception("Invalid key '$key'");
            }
        } else {
            $config->$key = $value;
        }
        return $config;
    }

    protected  function toObject(array $array) {
        $return = new \stdClass;

        foreach ($array as $key => $value) {
            $return->{$key} = (is_array($value) ? $this->toObject($value) : $value);
        }

        return $return;
    }


 /**
     * Install some tables needed by some modules. Some modules require their own tables in mysql only
     *
     * @param string $path
     * @return void
     */
    public static function installschema($path) {
         self::initALL () ;

        try {

            $schemaSql = file_get_contents($path);

            // use the connection directly to load sql in batches

            self::$_mysql->getConnection()->exec($schemaSql);

            if ('testing' != APPLICATION_ENV) {

                echo PHP_EOL;

                echo 'Tables and Data Created Successfully';
                echo PHP_EOL;
            }
        } catch (Exception $e) {

            echo 'AN ERROR HAS OCCURED: ' . PHP_EOL;

            echo $e->getMessage() . PHP_EOL;

            return false;
        }
    }


}

