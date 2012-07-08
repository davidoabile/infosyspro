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

 namespace Infosyspro\Sticky;

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
 class AbstractSticky implements Sticky
 {
     /* Zend\DI\Di*/
     protected $company;
     /* Zemd DB*/
     protected $db;
     protected $menuid = null;
     
     public function __construct( \Infosyspro\InfosysproLib $company = null, $menuid ='' )
     {
	 if ( null === $company ) return false;
         $this->company = $company;
	// var_dump($this->company->getAdapter()); exit;
          $this->db =  $company->getAdapter();
          $this->menuid = $menuid;
     }
     /**
      * Renders a class called by the view scripts
      * 
      * @param array|mixed $options
      * @return string  
      */
     public function render($options = null )
     {
        // $params = array();
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

 