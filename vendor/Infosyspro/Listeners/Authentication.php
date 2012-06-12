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

 namespace Infosyspro\Listeners;

use Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager as ZendEventManager,
    Zend\EventManager\Event as ZendEvent,
    Zend\ServiceManager\ServiceManager;

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
 class Authentication
 {

     protected static $events;
     protected static $locator;
     protected static $listeners = array();
     protected static $instance = null;

     public static function attachEvents(  ServiceManager $locator, EventCollection $events = null)
     {
         if (null !== $events) {
             self::$events = $events;
         } elseif (null === self::$events) {
             self::$events = new ZendEventManager(__CLASS__);
         }

         self::$locator = $locator;
       //  self::getInstance();
         self::attach();
         // return self::$events;
     }

      public static function getInstance()
     {
         if (null !== self::$instance) {
             return self::$instance;
         } else {
             self::$instance = new self();
         }
         return self::$instance;
     }

     public static function beforeLogin($id)
     {
         
     }

     public static function afterLogIn($data)
     {
         self::$events->trigger(__FUNCTION__, 'afterLogIn', $data);
     }

     public static function afterLogOut(Array $params)
     {
         self::$events->trigger(__FUNCTION__, 'afterLogOut', $params);
     }

     public static function attach(EventCollection $events= null)
     {
        // $userSession = self::$locator->get('userSessionManager');

         self::$listeners[] = self::$events->attach('afterLogIn', array(self::getInstance(), 'onLogIn'));

         self::$listeners[] = self::$events->attach('afterLogOut', array(self::getInstance(), 'onLogOff'));
     }

     public static function detach(EventCollection $events= null)
     {
        
         foreach (self::$listeners as $key => $listener) {
             self::$events->detach($listener);
             unset(self::$listeners[$key]);
             unset($listener);
         }
     }

     public function onLogIn(ZendEvent $e)
     {
         $lib = self::$locator->get('companyLib');
	 $userSession = $lib->getUserSession();

         $params = $e->getParams();

         $data = array('data' => json_encode($e->getParams()),
             'userid' => $params->id,
             'clientid' => $params->clientId,
             'guest' => $params->guest,
             'username' => $params->username,
         );
         $userSession->write(session_id(), $data);
     }

     public function onLogOff(ZendEvent $e)
     {
         $lib = self::$locator->get('companylib');
	 $userSession = $lib->getUserSession();
         $params = $e->getParams();
         $userSession->destroy($params['sessionId']);
     }

 }

 