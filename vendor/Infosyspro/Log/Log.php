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

 namespace Infosyspro\Log;

use Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager,
    Zend\Log\Logger as ZendLog,
    Zend\Log\Writer\Db as ZendLogWriterDb;

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

 class Log
 {

     protected static $events;
   
     protected static $db = null;

     public function __construct( $db, EventCollection $events = null)
     {

         self::$db = $db;
         self:$events = $events;
         self::attach();
       
     }

     public static function attachEvents($db, EventCollection $events = null)
     {
         if (null !== $events) {
             self::$events = $events;
         } elseif (null === self::$events) {
             self::$events = new EventManager(__CLASS__);
         }
         self::$db = $db;
         self::attach();
         return self::$events;
     }

     public static function addLog($message, $level = 0)
     {
         $params = compact('message', 'level');
        
         self::$events->trigger(__FUNCTION__, self, $params);
     }

     protected static function attach()
     {
         
          $columnMapping = array('priority' => 'priority', 'message' => 'message');
         $writer = new ZendLogWriterDb(self::$db, 'TbLogName', $columnMapping);

         $logger = new ZendLog($writer);

         self::$events->attach('addLog', function ($e) use ($logger) {
                     $event = $e->getName();
                     $target = get_class($e->getTarget());
                     $params = json_encode($e->getParams());
                     $logger->info(sprintf(
                                     '%s triggered using params %s', $event,  $params
                             ));
                 });
     }

 }

 