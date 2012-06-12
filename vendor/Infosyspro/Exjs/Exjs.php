<?php

namespace Infosyspro\Exjs ;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use Infosyspro\Traits;

/**
 * Description of Exjs
 *
 * @author davido
 */
class Exjs implements \Infosyspro\RestInterfaceClasses
{

    protected $infosyspro = null ;
    protected $user = null;

    public function __construct ( \Infosyspro\InfosysproLib $infosyspro )
    {
	$this->infosyspro = $infosyspro ;
	$this->user = $infosyspro->getUsers();
    }

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
    public function delete ( $id )
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
       /*
        $this->locator = $locator ;
	$users = new usersModel ( getDb () ) ;
	return $users->fetchAll () ;
        * 
        */
    }
    
    protected function listUsers($data = array()) {
        $users = $this->users->listUsers();
        return  json_encode($users);
    }
   
    /*
     *  This return modules from user of this session
     */

   public function getUserModules ()
    {
	$user = $this->user->getCurrentUserInfo ( );
	
	$id = (int) $user->id;
	$sql = "SELECT u.id, m.id, u.username,m.js,m.module,m.name,m.iconCls,up.shorcut,up.qLaunch, m.iconLaunch
			FROM OfficeUserGroups ug, OfficeUsers u, OfficeGroups g, OfficeGroupsModules gm, OfficeModules m ,
			OfficeUserPreferences up
			WHERE ug.userid = u.id AND  ug.groupid = g.id AND g.id = gm.groupid AND 
			m.id = gm.moduleid AND 	up.userid = u.id AND up.moduleid = m.id AND
			u.id=$id and m.js<>'Settings'
			GROUP BY js
			ORDER BY m.id " ;

	Traits\QuickSQL::processQuery ( $sql , $this->infosyspro->getAdapter () );
	
	return Traits\QuickSQL::getResults ();
    }

   public  function checkPermision ()
    {
	$user = $_SESSION["ExtDeskSession"]["username"] ;
	$id = $_SESSION["ExtDeskSession"]["id"] ;


	$module = $_GET["Module"] ;
	$option = $_GET["option"] ;
	$action = $_GET["action"] ;

	$sql = "select a.module, a.`option`, a.action,ug.idGroup,u.p_id
				from 
				groups_actions ga, 
				actions a, 
				user_groups 
				ug,modules m,
				groups g,
				users u
				where
				a.id=ga.idActions and ug.idGroup=ga.idGroups and 
				m.js=a.module and ga.idgroups=g.id and
				ug.idUser=u.p_id
				and g.active=1 
				and u.active=1
				and u.P_id=$id
				and a.module='$module'
				and a.`option`='$option'
				and a.action='$action'
				order by m.id
			" ;


	$stmt = $this->dbh->prepare ( $sql ) ;
	$stmt->execute () ;
	return $stmt->fetchAll ( PDO::FETCH_ASSOC ) ;
	
    }

    public function saveWallpaper ()
    {
	// get the params
	$user = $_SESSION["ExtDeskSession"]["username"] ;
	$wp = $_GET["p1"] ;
	$wp = str_replace ( "ico-" , "" , $wp ) ;
	$stretch = ($_GET["p2"] == 'true') ? 1 : 0 ;

	// create de sql
	$sql = "UPDATE users 
				SET 
				wallPaper=:wp, 
				wpStretch=:stretch
				WHERE username=:user" ;

	$result = $this->dbh->prepare ( $sql ) ;
	if ( $result->execute ( array ( ':wp' => $wp , ':stretch' => $stretch , ':user' => $user ) ) ) {
	    $res = TRUE ;
	} else {
	    $res = FALSE ;
	}
	return $res ;
    }

    public function saveShortcuts ()
    {
	$id = $_SESSION["ExtDeskSession"]["id"] ;
	$post = json_decode ( $_GET["jsonp"] ) ;
	$c = 0 ;
	foreach ( $post as $key ) {
	    $idmodule = $key->id ;
	    $shortcut = $key->shorcut ;
	    $sql = "UPDATE user_preferences SET shorcut=$shortcut WHERE idUser='$id' and idModule='$idmodule';" ;
	    $stmt = $this->dbh->prepare ( $sql ) ;
	    $c = $stmt->execute () ;
	}
	if ( $c == 0 ) {
	    return FALSE ;
	} else {
	    return TRUE ;
	}
    }

    public function saveQLaunchs ()
    {

	$id = $_SESSION["ExtDeskSession"]["id"] ;
	$post = json_decode ( $_GET["jsonp"] ) ;
	$c = 0 ;
	foreach ( $post as $key ) {
	    $idmodule = $key->id ;
	    $qLaunch = $key->qLaunch ;
	    $sql = "UPDATE user_preferences SET qLaunch=$qLaunch WHERE idUser='$id' and idModule='$idmodule';" ;
	    $stmt = $this->dbh->prepare ( $sql ) ;
	    $c = $stmt->execute () ;
	}
	if ( $c == 0 ) {
	    return FALSE ;
	} else {
	    return TRUE ;
	}
    }

   public function saveTheme ()
    {
	// get the params
	$user = $_SESSION["ExtDeskSession"]["username"] ;
	$theme = $_GET["theme"] ;
	// create de sql
	$sql = "UPDATE users 
				SET 
				theme='$theme' 
				WHERE username='$user'" ;
	$result = $this->dbh->prepare ( $sql ) ;

	if ( $result->execute () ) {
	    $res = TRUE ;
	} else {
	    $res = FALSE ;
	}
	return $res ;
    }

    protected function getUserSettings ()
    {
	
	$userProfile = array ('id' => 1,
		         'name' => 'davido',
                         'wallPaper' => 'Blue',
                         'theme' => 'pop',
		       'wallpaperStretch' => 1 
                       );


        $response = array ('success' => true, 'login' => true) ;
	// we print user data
	$response['user'] = $userProfile;        
	$response['user']['strings'] = $this->getJasonString () ;
        $response['user']['modules'] =  $this->getUserModules () ;

	return $response ;
    }

    public function loadUser ()
    {
	
	if ( $this->user->isLoggedIn () ) {	   
	   return $this->getUserSettings();
	} else {
	    $response = array ('success' => false, 'login' => false) ;
	    
	}
	return $this->_getDefaults($response);
    }
    
    protected function _getDefaults ($data )
    {
	$response = $data;
        $response['user'] = array(array('strings' => $this->getJasonString()));        
	return $response;
    }
    
     public function listUserGroups() {
        $sql = 'SELECT * FROM OfficeGroups';
	return $this->_getQuery($sql );
    }
    
    public function getUserGroup($data ) {
        $id = $data['id'];
        $sql = "SELECT $id as user,id,`group`,
				(SELECT IF(COUNT(1)>0,1,0)
					FROM OfficeUserGroups
					WHERE userid=$id AND groupid=g.id
				) AS selected
				FROM OfficeGroups g";
        
        return $this->_getQuery($sql);
    }
    
    protected function getModuleByName($data ) {        
        return $this->_getQuery( $sql = 'SELECT * FROM OfficeActions WHERE module="' . $data['module'] .'"');
    }
    protected function getModules() {
        $sql = 'SELECT * FROM OfficeModules';
		
	return $this->_getQuery($sql ) ;
    }
    
    protected function _getQuery($sql ) {
        Traits\QuickSQL::processQuery ( $sql , $this->infosyspro->getAdapter () );	
	return Traits\QuickSQL::getResults () ;
    }
    protected function getJasonString() {
	$ln = include APPLICATION_PATH . '/public/media/myofficeapps/client/languages/en.json' ;
	$data = str_replace ( "'" , '"' , $ln['lan'] ) ;
       return json_decode($data , true);
    }
}

