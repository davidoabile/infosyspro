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

 namespace Infosyspro\Blocks;

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
 class AbstractBlocks implements Blocks
 {
     /* Zend\DI\Di*/
     protected $locator;
     
     public function __construct( \Zend\Di\Di $locator= null )
     {
          $this->locator = $locator;
     }
     /**
      * Renders a class called by the view scripts
      * 
      * @param array|mixed $options
      * @return string  
      */
     public function render($options = null )
     {
         $params = $options['params'];
	 unset($options['params']);
        
        /* if(isset($options['params'])) {
            $params = json_decode(str_replace("'",'"',$options['params']), true);
         }
	 * 
	 */
         
         if (array_key_exists('function', $options)) {
             return $this->$options['function']($params);
         }
        
         return $this->init();
     }

     /**
      * Default data to be returned if no function exists
      * @return string 
      */
     public function init()
     {
         return 'No data found please check you spelling';
     }

 }

 