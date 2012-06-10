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

use Another_name_space;

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
 class MessageQueue
 {

         /**
          * The application message queue.
          *
          * @var    array
          * @since  11.1
          */
         protected $_messageQueue = array();


         /**
          * Class constructor.
          *
          * @param   array  $config  A configuration array including optional elements such as session
          *                          session_name, clientId and others. This is not exhaustive.
          *
          * @since   11.1
          */
         public function __construct($config = array())
         {
         }
         
         /**
          * Enqueue a system message.
          *
          * @param   string   $msg   The message to enqueue.
          * @param   string   $type  The message type. Default is message.
          *
          * @return  void
          *
          * @since   11.1
          */
         public function enqueueMessage($msg, $type = 'message')
         {
            
             // Enqueue the message.
             $this->_messageQueue[] = array('message' => $msg, 'type' => strtolower($type));
         }

         /**
          * Get the system message queue.
          *
          * @return  array  The system message queue.
          *
          * @since   11.1
          */
         public function getMessageQueue()
         {
            
             return $this->_messageQueue;
         }

         /**
          * Renders the error stack and returns the results as a string
          *
          * @param   string  $name    (unused)
          * @param   array   $params  Associative array of values
          * @param   string  $content
          *
          * @return  string  The output of the script
          *
          * @since   11.1
          */
         public function render($name, $params = array(), $content = null)
         {
             // Initialise variables.
             $buffer = null;
             $lists = null;

             // Get the message queue
             $messages = JFactory::getApplication()->getMessageQueue();

             // Build the sorted message list
             if (is_array($messages) && !empty($messages)) {
                 foreach ($messages as $msg) {
                     if (isset($msg['type']) && isset($msg['message'])) {
                         $lists[$msg['type']][] = $msg['message'];
                     }
                 }
             }

             // Build the return string
             $buffer .= "\n<div id=\"system-message-container\">";

             // If messages exist render them
             if (is_array($lists)) {
                 $buffer .= "\n<dl id=\"system-message\">";
                 foreach ($lists as $type => $msgs) {
                     if (count($msgs)) {
                         $buffer .= "\n<dt class=\"" . strtolower($type) . "\">" . JText::_($type) . "</dt>";
                         $buffer .= "\n<dd class=\"" . strtolower($type) . " message\">";
                         $buffer .= "\n\t<ul>";
                         foreach ($msgs as $msg) {
                             $buffer .="\n\t\t<li>" . $msg . "</li>";
                         }
                         $buffer .= "\n\t</ul>";
                         $buffer .= "\n</dd>";
                     }
                 }
                 $buffer .= "\n</dl>";
             }

             $buffer .= "\n</div>";
             return $buffer;
         }

     }

     