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

use   Zend\ServiceManager\ServiceManager;

/**
 * Class for connecting to SQL databases and performing common operations.
 * Zend\\ServiceManager\\ServiceManager
 * @uses       \Zend\Db\Db 
 * @category   Zend
 * @package    Zend_Db
 * @subpackage Adapter
 * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
 * @license    http://infosyspro.com/license     New Infosyspro License
 * @author    David Oabile <doabile@infosyspro.com.au>
 * 
 */
abstract class AbstractDataManager
{
    
    
    protected  $adapter;
    
    protected $userSession = null;
    protected $language = null;
   protected $articleLib = null;
    /** 
     * @var The view object 
     */
    protected $view;
    
    /**
     * @var The user object
     */
    protected $user;
    
    /**
     *
     * @var Session Object
     */
    protected $session;
    
    protected $locator = null;
    
    //Load database configuration
    protected $config = null;
    protected $office = null;
    

    /**
     * initial all objects View and the $locator
     * from the application instance
     * 
     * @param Application $instance 
     *   Zend\\ServiceManager\\ServiceManager
     * @return void
     */
    public function __construct(ServiceManager $locator = null)
    {
       $this->locator = $locator; 
       $this->adapter = $locator->get('db-adapter');
       $this->view = $locator->get('viewrenderer ');
    }
      
      /**
     * Get the user object
     * 
     * @return object
     */
    public function getUsers() {
	if(null == $this->user ) {
            $session = User\UserManager::getInstance();
	    $this->user = new User\UserManager($session, $this->locator);
	}
	return $this->user;
    }
    
     /**
	 * Get a session object
	 *
	 * Returns the global {@link Zend Session} object, only creating it
	 * if it doesn't already exist.
	 *
	 * @param   array  $options  An array containing session options
	 *
	 * @see Zend\Session
	 *
	 * @return Zend\Session object
	 * @since   1.0
	 *
	 */
	
     public function getSession()
     {
	 if(null === $this->session) {
	     $this->session = $this->locator->get('session');
	 }
         return $this->session;
     }
     
     /**
      * Get configuration instance
      * 
      * @uses Config\ModuleConfig
      * @return object
      */
     public function getConfig() {
	 if( !$this->config instanceof Config\ModuleConfig ) {
	     $this->config = new Config\ModuleConfig( $this->getAdapter ());
	 }
	 return $this->config;
     }
     
     public function getUserSession(){
	 if( ! $this->userSession instanceof Session\UserSessionManager) {
	     $this->userSession = new Session\UserSessionManager($this->getAdapter());
	 }
	 return $this->userSession;
     }
     public function getOffice() {
	 if( !$this->office instanceof Exjs\Exjs ) {
	     $this->office = new Exjs\Exjs($this);
	 }
	 return $this->office;
     }
     public function getAdapter() {
	 if( null === $this->adapter) {
	      $this->adapter = $this->locator->get('db-adapter');
	 }
	 return $this->adapter;
     }
     
     public function getArticle()
     {
         if(null === $this->articleLib ) {
             $this->articleLib = new Content\Article($this);
         }
         return $this->articleLib;
     }
     
     
     public function getLanguage()
     {
         if( null === $this->language ) {
            $this->language = $this->locator->get('translator');
         }
         return $this->language;
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
}

