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

 namespace Infosyspro\Mail;

use Zend\Mail\Mail as ZendMail,
    Zend\Mail\Transport\Smtp as ZendTransportSmtp,
    Zend\Mail\Protocol\Smtp as ZendProtocolSmtp,
    Company\Config\ModuleConfig;

 /**
  * Class for dealing with emails.
  *
  * @uses       \Zend\Mail 
  * @category   Infosyspro
  * @package    Zend_Db
  * @subpackage Adapter
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 class Mail
 {

     protected $config;
     protected $transport;

     public function __construct(ModuleConfig $configInstance)
     {
         $this->init($configInstance);
     }

     public function sendMail($mailTemplate='test', $subject = 'test', 
                               $recipients = array(array('name' => 'David Oabile', 
                                                    'email'=> 'doabile@infosyspro.com.au')))
     {
        ZendMail::setDefaultFrom($this->config['mail']['sentFrom'], $this->config['mail']['sentFromName']) ;
        ZendMail::setDefaultReplyTo($this->config['mail']['sentFrom'], $this->config['mail']['sentFromName']);
        
         foreach ($recipients as $recipient) {
             $mail = new ZendMail();
             if ($this->config['mail']['useHtml']) {
                 $mail->setBodyHtml($mailTemplate);
             } else {
                 $mail->setBodyText($mailTemplate);
             }

           
             $mail->addTo($recipient['email'], $recipient['name']);

             if (isset($this->config['mail']['CCTo'])) {
                 $mail->addCc($this->config['mail']['CCTo']);
             }
             $mail->setSubject($subject);
             $mail->send($this->transport);
         }
         //reset defaults
         ZendMail::clearDefaultFrom();
         ZendMail::clearDefaultReplyTo();
     }

     protected function init($instance)
     {
         $where = array('where' => array('moduleName' => 'mailConfig'),
             'orWhere' => array('moduleName' => 'all'),
         );

         $this->config = $instance->loadDbConfig($where, false);
         $config = $this->config['mail'];
         unset($config['name']);
         $this->transport = new ZendTransportSmtp($config['host'], $config);
     }

     protected function getMailTemplate($mailTemplateId)
     {
         
     }

 }

 