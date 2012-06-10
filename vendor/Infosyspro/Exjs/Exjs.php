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

    public function start ()
    {

	/*	 * * Paths of system ** */
	$this->libPath = 'server/lib/' ;
	$this->incPath = 'server/include/' ;
	$this->incLang = 'client/languages/' ;

	/*	 * * Loading libraries ** */
	$this->load ( $this->incPath . 'class.configFile.php' , 'configFile' , true ) ;
	$this->load ( $this->incPath . 'class.utils.php' , 'utils' , true ) ;
	$this->load ( $this->incPath . 'class.security.php' , 'Settings' , true ) ;
	$this->load ( $this->incPath . 'class.user.php' , 'security' , true ) ;
	$this->load ( $this->incPath . 'class.modules.php' , 'security' , true ) ;

	/*	 * * Load in SESSION var ** */
	$this->iniConfig = new configFile() ;

	/*	 * * Load the languaje file definided in config.ini** */
	$this->utils = new utils ;
	$this->lang = $this->utils->loadJson ( $this->incLang . _LANGUAGE . '.json' ) ;

	/*	 * * if debug is 1, then load de firePHP** */
	if ( _DEBUG == '1' ) {
	    $this->load ( $this->libPath . "FirePHPCore/FirePHP.class.php" , 'FirePHP' , true ) ;
	}
	$this->load ( $this->incPath . "class.debug.php" , 'debug' , true ) ;
	$this->debug = new debug ;
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
    
    public function process ()
    {

	//load de security class
	$sec = new security ;

	// if the user data send user and password post...!!
	if ( !empty ( $_POST ) && !empty ( $_POST["user"] ) && !empty ( $_POST["password"] ) ) {
	    //we try to log in...!!
	    $res = $sec->login ( $_POST["user"] , $_POST["password"] ) ;
	}

	// verify if we are login, this check session, and check 
	$res = $sec->loged () ;

	if ( $res["success"] ) {

	    //check the action we need	
	    //$this->debug->log($_GET);

	    switch ( $_GET["Module"] ) {

		case "Main" :
		    switch ( $_GET["action"] ) {
			case "load_user":
			    // we get the language strings
			    $language = json_encode ( $this->lang["language"] ) ;

			    // send a ok signal
			    $json = '{	"success" : true, "login": true,' ;

			    // we print user data
			    $json = $json . '"user" : [{' . $sec->print_user () ;
			    $json = $json . '"strings":' . $languaje . "," ;
			    $modules = new modules ;
			    $moduleStr = $modules->getUserModules () ;
			    $json = $json . '"modules": ' . $moduleStr . ' }  ]}' ;
			    echo $json ;
			    break ;
		    }//<--end case action
		    break ;
		default:
		    //first check the user permisión
		    //this is a generic function
		    $modules = new modules ;
		    $permision = $modules->checkPermision () ;

		    //KILL THIS FUCKING LINE IS JUST TO TEST
		    //$permision=1;
		    //$this->debug->log(var_dump($permision));
		    if ( $permision == 1 ) {

			switch ( $_GET['Module'] ) {
			    case 'Settings':
				switch ( $_GET['option'] ) {
				    case 'Wallpaper':
					if ( $_GET['action'] = "save" ) {
					    $isSet = $modules->saveWallpaper () ;
					    if ( !$isSet ) {
						echo '{success:false, msg:"No se realizaron los cambios en el servidor"}' ;
					    } else {
						echo '{success:true, msg:"Guardado"}' ;
					    }
					}
					break ;
				    case "Shortcuts":
					if ( $_GET['action'] = "save" ) {
					    $isSet = $modules->saveShortcuts () ;
					    if ( !$isSet ) {
						echo '{success:false, msg:"No se realizaron los cambios en el servidor"}' ;
					    } else {
						echo '{success:true, msg:"Guardado"}' ;
					    }
					}
					break ;
				    case "QLaunchs":
					if ( $_GET['action'] = "save" ) {
					    $isSet = $modules->saveQLaunchs () ;
					    if ( !$isSet ) {
						echo '{success:false, msg:"No se realizaron los cambios en el servidor"}' ;
					    } else {
						echo '{success:true, msg:"Guardado"}' ;
					    }
					}
					break ;
				    case 'Theme':
					if ( $_GET['action'] = "save" ) {
					    $isSet = $modules->saveTheme () ;
					    if ( !$isSet ) {
						echo '{success:false, msg:"No se realizaron los cambios en el servidor"}' ;
					    } else {
						echo '{success:true, msg:"Guardado"}' ;
					    }
					}
					break ;
				}//<--end case option
				break ;
			    default:

				// if we have access,
				// 1.- Load the class, we create the path for you
				// 2.- We inicialize the class for you
				// 3.- We call the method for you...

				$Module = $_GET["Module"] ;
				$option = $_GET["option"] ;
				$action = $_GET["action"] ;
				$lower = strtolower ( $Module ) ;
				$Path = "modules/$Module/Server/$Module.php" ;

				$initClass = "$" . $lower . "= new $Module;" ;
				$Function = "$" . "$lower->$option" . "_$action();" ;
				$this->load ( $Path , 'configFile' , true ) ;
				if ( class_exists ( $Module ) ) {
				    eval ( $initClass ) ;
				    $variable = $lower ;
				    $method = $option . "_$action" ;
				    if ( method_exists ( ($lower ) , $method ) ) {
					eval ( $Function ) ;
				    } else {
					die ( '{"success" : false,msg:"The method does not exist."}' ) ;
				    }
				} else {
				    die ( '{"success" : true,msg:"saved"}' ) ;
				}
				break ;
			}//<--end case Module
		    } else {
			//you can in
			echo '{success:false, msg:"No tienes los permisos necesarios<br/><br/>Por favor consulta con tu administrador"}' ;
		    }//end if permision

		    break ;
	    }//end case Module
	} else {
	    // we are not logged
	    // just send de languaje strings...
	    $languaje = json_encode ( $this->lang["languaje"] ) ;
	    $json = '{	"success" : false, "login": false,' ;
	    $json = $json . '"user" : [{' ;
	    $json = $json . '"strings":' . $languaje . "}]}" ;

	    //OutPut Json
	    echo $json ;
	}//<-- end if ($res["success"])
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
	
	//$debug->log(json_encode($result));
	return json_encode ( Traits\QuickSQL::getResults () ) ;
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

    public function getUserSettings ()
    {
	if ( !$this->user->isLoggedIn () ) {
	    return $this->_getDefaults ( '{"success" : false, "login": false,' ) ;
	}
	$string = ' "id" : "1",
		"name" :"davido",' .
		'"wallPaper": "Blue",' .
		'"theme": "pop",' .
		'"wallpaperStretch" : 1,' ;

	$json = '{"success" : true, "login": true,' ;

	// we print user data
	$json = $json . '"user" : [{' . $string ;
	$json = $json . '"strings":' . $this->getJasonString () . "," ;

	$json = $json . '"modules": ' . $this->getUserModules () . ' }  ]}' ;




	return $json ;
    }

    public function loadUser ()
    {
	//$user = $this->user->getCurrentUserInfo ( );
	//$sess = $this->infosyspro->getUserSession();
	//$id = $sess->getSessionId();
	//var_dump($sess->read($id)); exit;
	if ( $this->user->isLoggedIn () ) {	   
	   return $this->getUserSettings();
	} else {
	    $response = '{"success" : false, "login": false,' ;
	    
	}
	return $this->_getDefaults($response);
    }
    
    protected function _getDefaults ( $data )
    {
	$ln = include APPLICATION_PATH . '/public/media/cms/client/languages/en.json' ;
	$jsLan = str_replace ( "'" , '"' , $ln['lan'] ) ;
	$json = $data ;
	$json .= '"user" : [{' ;
	$json .= '"strings":' . $jsLan . "}]}" ;

	return $json ;
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
	$ln = include APPLICATION_PATH . '/public/media/cms/client/languages/en.json' ;
	return str_replace ( "'" , '"' , $ln['lan'] ) ;
    }
}

