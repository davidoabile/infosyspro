<?php

 /**
  * Infosyspro Framework
  *
  * LICENSE
  *
  * This source file is subject to the new BSD license that is bundled
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

 namespace Myofficeapps\View\Helper;

use Zend\View\Helper,
    Zend\View\HelperBroker,
    Zend\View\Helper\AbstractHelper;

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
 class MyofficeappsHelper extends HelperBroker 
 {
     //protected $defaultClassLoader = 'Cms\View\Helper\CmsHelper';
     /**
      * Load and return a plugin instance
      * 
      * @param  string $plugin 
      * @param  array $options Options to pass to the plugin constructor
      * @return object
      * @throws Exception if plugin not found
      */
     public function load($plugin, array $options = null)
     {
         $pluginName = strtolower($plugin);
         if (isset($this->plugins[$pluginName])) {
             return $this->plugins[$pluginName];
         }
         // $class = 'Cms\\View\Helper\\' . $plugin;
         if (class_exists(__NAMESPACE__ . '\\' . $plugin)) {
             // Allow loading fully-qualified class names via the broker
             $class = __NAMESPACE__ . '\\' . $plugin;
         } else {
             $calss = parent::load($plugin, $options);
         }

         if (empty($options)) {
             $instance = new $class();
         } elseif ($this->isAssocArray($options)) {
             $instance = new $class($options);
         } else {
             $r = new \ReflectionClass($class);
             $instance = $r->newInstanceArgs($options);
         }

         if ($this->getRegisterPluginsOnLoad()) {
             $this->register($pluginName, $instance);
         }

         return $instance;
     }

 }

 