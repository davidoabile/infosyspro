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
 class MessageQueue extends AbstractSticky
 {
    
     /**
      * Renders the error stack and returns the results as a string
      *         
      * @return  string  The output of the script
      *
      * @since   1.0
      */
     public function __construct($company = ''){
         
         if($this->company === null) {
             parent::__construct( $company);
         }        
     }
     public function init()
     {
         // Initialise variables.
         $buffer = null;
         $lists = null;
        
         if ($this->company->getSession()->getKey('message')) {
             $messages = array($this->company->getSession()->getKey('message'));

             // Build the sorted message list
             if (is_array($messages)) {
                 foreach ($messages as $k => $v) {
                     $lists[$v['type']][] = $v['message'];
                 }
             }
           
             // Build the return string
             $buffer .= "\n<div id=\"system-message-container\">";

             // If messages exist render them
             if (is_array($lists)) {
                 $buffer .= "\n<dl id=\"system-message\">";
                 foreach ($lists as $type => $msgs) {
                     if (count($msgs)) {
                         $buffer .= "\n<dt class=\"" . strtolower($type) . "\">" . $type . "</dt>";
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

             $company->getSession()->removeKey('message');
         }
         return $buffer;
     }

 }

 