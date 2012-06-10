<?php

 /**
  * Infosyspro Framework
  *
  * LICENSE
  *
  * This source file is subject to the PRIVATE license that is bundled
  * with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * http://infosyspro.com/license
  * If you did not receive a copy of the license and are unable to
  * obtain it through the world-wide-web, please send an email
  * to support@infosyspro.com so we can send you a copy immediately.
  *
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage Translator
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 /**
  * @namespace
  */

 namespace Infosyspro\Translator;

use Zend\Translator\Translator as ZendTranslator,
       Zend\Cache\StorageFactory as ZendCache;

 /**
  * Class for translating Core statements.
  *
  * @uses       \Zend\Cache\Cache
  * @uses       \Zend\Translator\Translator
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage Translator
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 class Translator extends ZendTranslator
 {
    
     
     public function __construct(Array $options) 
     {
        
         /* Set caching for this translator as it might grow very huge */
      /*   $cache = ZendCache::factory( array('adapter' => 'filesystem',
                                              'options' =>    array(
                                                    'ttl' => 7200,
                                                   
                                                  ),
                                      )            
                  );
         
       
         self::setCache($cache);         
        //self::clearCache();
       * */
       
         parent::__construct($options);        
     }
     
     /**
      * Get a string translated to the appropriate language.
      * Default to English if no language exists in the session.
      * The session is created either by the user selection or user login
      * 
      * 
      * @param string $id ID of the string
      * @return string translated string
      */
     public function translate($id)
     {
        /* Language passed during instantiation */
         $lan = $this->getLocale();
         /* either invoked by the user or login listener */        
         if(isset($_SESSION['__ZF'])) {
             if(isset($_SESSION['__ZF']['lang'])) {
                $lan = $_SESSION['__ZF']['lang'];
             }
         }
        
         return $this->_($id,$lan);
     }
 }

 