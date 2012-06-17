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
class Exjs extends \Infosyspro\AbstractRestFul
{

    
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

	return $this->_getQuery($sql);
    }

    /**
     * Get roles associated with a resource
     * 
     * @return array result
     */
   
    public function listResourceRoles( $data ) {
         $id = $data['id'];
         $module = (!empty($data['module'])) ? $data['module'] : 'Settings' ;
      
        $sql = "select $id as parent, id  as id,module,`option` as opt,action,
				(
					select if(count(1)>0,1,0)
					from OfficeGroupsActions ga 
					where groupid=$id and actionid=a.id
				) as selected
				from OfficeActions a
				where module='$module'
				order by id
			";

       return $this->_getQuery($sql);
    }
    
    
    
     public function listGroups() {
        $sql = 'SELECT * FROM OfficeGroups';
	return $this->_getQuery($sql );
    }
    
    public function listModulesInAGroup( $data ) {
         $id = $data['id'];
        $sql = "select $id as parent, id  as id,js,
				(select count(id) from OfficeGroupsModules where groupid=$id and moduleid=m.id) as selected
				from OfficeModules m";
        
        return $this->_getQuery($sql);
    }
    
    public function listActionsGroups ( $data ) {
	//var_dump($data); exit;
	$id = $data['id'];
         $module = (!empty($data['module'])) ? $data['module'] : 'Settings' ;
      
        $sql = "SELECT $id AS parent, id  as id,module,`option` as opt,action,
				(
				  SELECT IF(COUNT(1)>0,1,0)
				  FROM OfficeGroupsActions ga 
				  WHERE groupid=$id AND actionid=a.id
				) as selected
		FROM OfficeActions a
		WHERE module='$module'
		ORDER BY id";
	//echo $sql; exit;
	 return $this->_getQuery($sql);
	
    }
    
    public function saveGroups($data)
    {
        $model = $this->infosyspro->getModel('Myofficeapps\Model\OfficeGroups');
        $i = 0;
  
        foreach ($data as $index => $sqlData) {
            if( $sqlData['id'] == 0 ) {
                $model->insert($sqlData );
            } elseif($sqlData['id'] > 0) {
                $model->update($sqlData,  array ( 'id' => $sqlData['id'] ) );
            }
	    
            $i++;
        }
        return $this->_updateResult($i);
       
    }
    
    public function deleteGroups( $data )
    {
	$i = 0;
	
	if ($data['id'] > 0) {
	    $model = $this->infosyspro->getModel('Myofficeapps\Model\OfficeGroups');
	    if($model->delete($data))
	    {
		$i = 1;
	    }
	    return $this->_updateResult($i);
	}
	
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
	return $this->_getDefaults( $response );
    }
    
    protected function _getDefaults ($data )
    {
	$response = $data;
        $response['user'] = array(array('strings' => $this->getJasonString()));        
	return $response;
    }
    
    public function getUserGroups($data ) {
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
    
    protected function _updateResult($count)
    {
        
       if($count > 0 ) {
             return array ('success' => true, 'msg' => 'Saved  ' . $count . '.');
        } else {
           return array ('success' => false, 'msg' => 'Failed to save data');
           
        }
    }
}

