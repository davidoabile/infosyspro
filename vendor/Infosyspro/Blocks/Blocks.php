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
  * @subpackage Blocks
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
  * Class for translating Core statements.
  *
  * @uses       \Zend\Cache\Cache
  * @uses       \Zend\Translator\Translator
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage Blocks
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 interface Blocks
 {
     public function render();
     public function init();
     
 }

 