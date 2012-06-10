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

namespace Infosyspro;

use Infosyspro\AbstractDataManager;

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
class InfosysproLib extends AbstractDataManager
{
    /**
     * Number of allowed failed login attemps
     * 
     * @var int configAllowedLoginTimes
     */
    protected $configAllowedLoginTimes = 3;
    
    /**
     * Holds the user object
     * 
     * @var string $user 
     */
    protected $user = null;
    
    
    public function setPageTitle( $title = 'No Title Set') 
    {
       
      $this->view->plugin('headTitle')->setAutoEscape(false)
                                     ->set($title);    
    }
    
   
    /**
     * A namespace model name to retrieve
     * This will return an object Zend\Db\TableGateway\AbstractTableGateway
     * @param string $model
     * @return \Infosyspro\model
     */
    public function getModel( $model ) {
	return new $model( $this->getAdapter() );
    }
    public function setHeadLink( $method, $options = array()) 
    {        
       //$view->plugin('headlink')->appendStylesheet('/styles/basicss.css'); OR
       $this->view->plugin('headlink')->__call($method,$options);
    }
    
    public function setHeadScript( $method, $options = array()) 
    {      
       $this->view->plugin('headscript')->__call($method,$options);
    }
    
    public function setHeadMeta($method, $options = array())
    {
        // setting meta keywords
         $this->view->plugin('headmeta')->__call($method,$options);
       // $this->headMeta()->appendName('keywords', 'framework, PHP, productivity');
   
    }
    
    public function getAllowedFailedLoginValue()
    {
        return $this->configAllowedLoginTimes;
    }
    
   
        
}

