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

namespace Infosyspro\User ;

use Zend\Authentication as authAdapter ,
    Zend\ServiceManager\ServiceManager,
    Infosyspro\Listeners\Authentication as InfosysproAuth ,   
    Infosyspro\RestInterfaceClasses ,
    Application\Model\TbUsers as usersModel,
    Application\Model\OfficeUsers as adminUsersModel ;


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
class UserManager implements RestInterfaceClasses
{

    /**
     *
     * @var object Zend\Authenticate 
     */
    protected static $authAdapter ;
    protected $locator = null ;
    protected $table ;
    protected $office = 0 ;
    protected $language = null;

    public function __construct ( authAdapter\AuthenticationService $instance = null , ServiceManager $locator = null )
    {
	//return $events;
	self::$authAdapter = $instance ;
	$this->locator = $locator ;
        $this->language = $locator->get('translator');
    }

    /**
     * Retrieve user's instance
     * 
     * @return Zend\Authenticate object
     */
    public static function getInstance ()
    {
	if ( null === self::$authAdapter ) {
	    self::$authAdapter = new authAdapter\AuthenticationService() ;
	}
	return self::$authAdapter ;
    }

    /**
     *  This is the authentication wrapper used to authenticate users
     * 
     * @param string $user username of the requestor
     * @param string $password of the requestor
     * @param string $cms whether this is a front end or backend access
     * @return bool 
     */
    public function authenticate ( $data  )    {

	if(!empty($data['office'])) {
            $this->office = 1;
             $data['table'] = 'OfficeUsers' ;
	    $data['usernameField'] = 'username';
	    $data['passowrdField'] = 'password';
            
        } else {
	    $data['table'] = 'TbUsers' ;
	    $data['usernameField'] = 'username';
	    $data['passowrdField'] = 'password';
	}
	if ( !empty ( $data['user'] ) && !empty ( $data['password'] ) ) {
	  //  $password = $this->setPassword ( $data['password'] ) ;
	    return $res = $this->auth ( $data ) ;
	}
	return false ;
    }

    /**
     * Change user's password
     * @param string $oldPass
     * @param string $newPass
     * @param int $clientid
     * @return array|assoc 
     */
    public function changePassword ( $oldPass , $newPass , $clientid )
    {

	if ( isset ( $_SESSION['username'] ) ) {
	    $pass = $this->setPassword ( $newPass ) ;
	   return $this->_response(true, 'passwordUpdated' ) ;
	} else {
	   return $this->_response(false , 'failedToUpdatePassword' ) ;
	}
	
    }

    /**
     * Encrypt the password
     * @param string $password
     * @return string sha1 pass
     */
    public function setPassword ( $password )
    {
	$salt = sha1 ( "9" . $password . "9" ) ;
	$password = $salt . $password . $salt ;
	return sha1 ( ($password ) ) ;
    }

    //Log the user out
    public function logout ()
    {

	if ( $this->isLoggedIn () ) {
	    //clear user details
	    self::getInstance ()->clearIdentity () ;
	    /* Trigger events after user has logged off */
	    InfosysproAuth::attachEvents ( $this->locator ) ;
	    InfosysproAuth::afterLogOut ( array ( 'sessionId' => session_id () ) ) ;
             return $this->_response(true, 'successfullyLoggedOut' ) ;
	} else {
	   return $this->_response(false, 'failedToLogout') ;
	}
    }

    //this function should only be called locally
    protected function auth ( Array $options )
    {
	$auth = self::getInstance () ;

	$authAdapter = new authAdapter\Adapter\DbTable (
			$this->getDb () ,
			$options['table'] , 
			$options['usernameField'] ,
			$options['passowrdField']
	) ;

	$authAdapter->setIdentity ( $options['user'] )
		->setCredential ( $options['password'] ) ;

	// get select object (by reference)
	$select = $authAdapter->getDbSelect () ;
	$select->where ( 'status = "1"' ) ;
	$result = $auth->authenticate ( $authAdapter ) ;

	if ( $result->isValid () ) {
	    // store the identity as an object
	    $storage = $auth->getStorage () ;
	    $data = $authAdapter->getResultRowObject ( null , 'password' ) ;
	    $data->clientId = $this->office ;
	    $data->guest = 0 ;
	    if ( $this->office ) {
		$data->clientId = 1 ;
	    }

	    /* Trigger events after user has login in */
	    InfosysproAuth::attachEvents ( $this->locator ) ;
	    InfosysproAuth::afterlogIn ( $data ) ;

	    $storage->write ( $authAdapter->getResultRowObject ( array ( 'id' , 'username' ) ) ) ;
            return $this->_response('true' , 'successfullyLoggedIn' );
	}

	return $this->_response('false' , 'invalidUsernameOrPassword' );
    }

    /**
     * RESTFull POST
     * @param array $locator
     * @param array $data
     * @return boolean 
     */
    public function create ( Array $data )
    {

	if ( isset ( $data['custom'] ) ) { //use custom class to process this
	    $class = __NAMESPACE__ . '\\' . str_replace ( '_' , '\\' , $data['custom'] ) ;
	    if ( !class_exists ( $class ) ) {
		echo $class ;
	    } else {
		$inst = new $class ( $data ) ;
		return true ;
	    }
	} else {
	    $method = strtolower ( array_pop ( explode ( '_' , $data['object'] ) ) ) ;
	    unset ( $data['object'] ) ;
	    if ( method_exists ( $this , $method ) ) {
		return $this->$method ( $data ) ;
	    }
	}
    }

    /**
     * RESTful delete
     * @param array $locator
     * @param init $id
     * @return boolean 
     */
    public function delete ( $id, Array $data )
    {
	$currentUser = self::$authAdapter->getIdentity () ;
	if ( $currentUser->id == $id ) {
	    return false ;
	}
	
	$users = new usersModel ( getDb () ) ;
	return $users->delete ( $id ) ;
    }

    /**
     * RESTFul GET
     * @param array $locator
     * @param int $id
     * @param array $data
     * @return bool 
     */
    public function get ( $id , Array $data )
    {
        //check which method has been called
        if(!empty( $data['method'])) {
            $method = $data['method'];
        
        if(method_exists($this, $method)) {
            return $this->$method( $data);
        }
	
        }
       return false;
    }

    /**
     * RESTFul PUT
     * @param array $locator
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    public function update ( $id , Array $data )
    {
	$this->locator = $locator ;
	$users = new usersModel ( getDb () ) ;
	return $users->updateRow ( $data ) ;
    }

    public function getList (Array $data )
    {
	
        //check which method has been called
        if(!empty( $data['method'])) {
            $method = $data['method'];
       
        if(method_exists($this, $method)) {
            return $this->$method( $data);
        }
	
        }
       return false;
      
    }
    
    
     public  function getCurrentUserInfo ( )
    {
	self::getInstance () ;
	return self::$authAdapter->getIdentity () ;
    }
    public function isLoggedIn ()
    {
	self::getInstance () ;
	return self::$authAdapter->hasIdentity () ;
    }

    public function setLocator ( $locator )
    {
	$this->locator = $locator ;
	return $this->locator ;
    }

    public function getUserGroup ()
    {
	
    }

    public function getCustomerPriceBand ()
    {
	
    }

    public function forgotPassword ()
    {
	
    }

    public function getLastLogin ()
    {
	
    }

    public function lockUser ()
    {
	
    }

    
    public function listUsers(){
        $users = new usersModel ( $this->getDb () ) ;
	return $users->fetchAll () ;
    }

    public function listAdminUsers() {       
        $admins = new adminUsersModel( $this->getDb());
     
        return $admins->fetchAll();
    }
    
    
    public function removeSessionFromDb ()
    {
	
    }

    public function blockUserIP ()
    {
	$data = array (
	) ;

	$where = '' ;

	$table->update ( $data , $where ) ;
    }

    public function warnUserStatusChanged ()
    {
	
    }

    public function urlResetPassword ()
    {
	
    }

    public function checkPostcode ( $postcode )
    {
	
    }

    public function getAge ()
    {
	return 'you are old' ;
    }

    public function userDefaultAddress ( $mode = 'shipping' )
    {
	
    }

    protected function _checkPasswordPolicy ()
    {
	
    }

    protected function _uniqueLogin ( $customer_id , $contacts_id = false )
    {
	
    }

    //TODO: make this function protected 
    public function checkLoginCount ()
    {

	$session = $this->locator->get ( 'session' ) ;

	$storage = $session->getStorage () ;

	$count = 1 ;

	if ( $count = @$storage->offsetGet ( 'count' ) ) {
	    $count++ ;
	    $storage->offsetSet ( 'count' , $count ) ;
	} else {
	    $storage->offsetSet ( 'count' , 1 ) ;
	}
	//$session->destroy();
	//TODO: get this from the config
	return $count ;
    }

    protected function getDb ()
    {
	return $this->getLocator ()->get ( 'db-adapter' ) ;
       // trigger_error ( 'User Manager $locator must be an instanceof \Zend\Di' , E_USER_ERROR ) ;
    }

    protected function getLocator ()
    {
	if ( $this->locator instanceof ServiceManager ) {
	    return $this->locator ;
	}
	trigger_error ( 'User Manager $locator must be an instanceof \Zend\Di' , E_USER_ERROR ) ;
    }

    protected function generatePassword ( $length = 9 , $strength = 0 )
    {
	$vowels = 'aeuy' ;
	$consonants = 'bdghjmnpqrstvz' ;
	if ( $strength & 1 ) {
	    $consonants .= 'BDGHJLMNPQRSTVWXZ' ;
	}
	if ( $strength & 2 ) {
	    $vowels .= "AEUY" ;
	}
	if ( $strength & 4 ) {
	    $consonants .= '23456789' ;
	}
	if ( $strength & 8 ) {
	    $consonants .= '@#$%' ;
	}

	$password = '' ;
	$alt = time () % 2 ;
	for ( $i = 0 ; $i < $length ; $i++ ) {
	    if ( $alt == 1 ) {
		$password .= $consonants[(rand () % strlen ( $consonants ))] ;
		$alt = 0 ;
	    } else {
		$password .= $vowels[(rand () % strlen ( $vowels ))] ;
		$alt = 1 ;
	    }
	}
	return $password ;
    }

    protected function _response($flag, $lanId ) 
    {
        return array ( 'success' => (bool) $flag , 'msg' => $this->language->translate($lanId)) ;
	
    }
}

