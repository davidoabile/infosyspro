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

namespace Cms\Controller;

use Cms\Model\Modeltable;

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
class LoginController extends ActionController {

    protected $company;

    public function indexAction() {
        $this->company = $this->locator->get('companylib');
        $this->company->setPageTitle('Login into Content Management');
        //   $this->company->setHeadLink('appendStylesheet',array('/media/cms/css/system.css'));
        // $this->company->setHeadLink('appendStylesheet',array('/media/cms/css/template.css'));

        /* Validate the form */
     /*   if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            //authenticate the user
            if ($form_login->isValid($formData)) {

                $res = My_General::loginhook($this->_request->getParam('login'), $this->_request->getParam('pass'));

                switch ($res->getCode()) {

                    case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                        $msg = 'Invalid username and or password';
                        $dialog_title = 'Invalid User';
                        break;

                    case Zend_Auth_Result::SUCCESS:
                        $this->_redirect('/index/index');
                        break;

                    default:
                        $msg = 'Unknown error has occurred';
                        $dialog_title = 'Unknown ERROR';
                        break;
                }
            } else {

                $form_login->populate($formData);
            }
        }

        //is the user authenticated?
        if (!Zend_Auth::getInstance()->hasIdentity()) {

            $this->view->dialog = 'SET';
            $this->view->dialog_contents = $msg;
            $this->view->dialog_title = $dialog_title;

            //sprintf($dialog_contents,$dialog_title,$msg);
        }

*/

        return array();
    }

}

