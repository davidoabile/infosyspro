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

namespace Cms\Form;

use Zend\Form\Form as ZendForm,
    Zend\Form\Element;

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
class Login extends ZendForm
{


 public $elementDecorators = array(
       
               'ViewHelper',
               'Errors',
           //   'Description' => array('tag' => 'p', 'class' => 'description'),
               array(array('data' => 'HtmlTag'), array('tag' => '<span>')),
        array('label' , array('tag' => '<span>', 'class' => 'mod-login-username-lbl')),
       // array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        
    );

    public $buttonDecorators = array(
         'ViewHelper',
               'Errors',
         array(array('label' => 'HtmlTag'), array('tag' => '<div>', 'class' => 'button1')),
         array(array('data' => 'HtmlTag'), array('tag' => '<div>', 'class' =>'button-holder')),
       

    );

 public function loadDefaultDecorators()
    {
       $this->addDecorator('FormElements')
                 ->addDecorator('HtmlTag', array('tag' => 'fieldset', 'class' => 'loginform'))
                 ->addDecorator('FormDecorator');     
    }

    public function init() {
        $this->setName('login');
        $this->setOptions(array('id'=>'form-login'));
     
        $username = new Element\Text('username');
        $username->setLabel('Username')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setDecorators($this->elementDecorators )
                ->setOptions(array('class'=> 'inputbox','id'=>'mod-login-username', 
                    'class'=> 'inputbox', 'size'=>'15'));
        //id="mod-login-username" type="text" class="inputbox" size="15" 
        $password = new Element\Password('password');
        $password->setLabel('Password')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                 ->setDecorators($this->elementDecorators )
                ->addValidator('NotEmpty')
                ->setOptions(array('class'=> 'inputbox','id'=>'mod-login-password', 
                    'class'=> 'inputbox', 'size'=>'15'));
       // $submit = new Element\Submit('submit');
       // $submit->setAttrib('id', 'submitbutton')
        //        ->setDecorators($this->buttonDecorators);
        $this->addElements(array($username, $password));
    }

}

