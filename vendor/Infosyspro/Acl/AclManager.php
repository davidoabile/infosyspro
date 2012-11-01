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

namespace Infosyspro\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\Db\Sql\Sql;

/**
 * Put simply, roles request access to resources. For example, 
 * if a parking attendant requests access to a car, 
 * then the parking attendant is the requesting role, 
 * and the car is the resource, since access to the car may 
 * not be granted to everyone.
 *
 * @uses       \Zend\ACL
 * @subpackage Adapter
 * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
 * @license    http://infosyspro.com/license     New Infosyspro License
 * @author    David Oabile <doabile@infosyspro.com.au>
 * 
 */
class AclManager extends \Infosyspro\AbstractRestFul
{

    protected $acl = null;

    /* Define table constants */

    const ACLDRTABLE = 'acl_dr_roles';
    const ACLSTAFFTABLE = 'acl_staff_roles';
    const PRIMARYKEY = 'seqno';

    /**
     *
     * @var object AclAdapter object
     */
    protected $roleAdapter = null;
    protected $aclResources = null;
    protected $aclTable = self::ACLDRTABLE;
    protected $aclPrivileges = null;

    /**
     * Organise ACLs from the database
     * 
     * @param \Zend\Db\Adapter\Adapter $adapter   
     */
    public function init()
    {

	$this->acl = new ZendAcl();
	//$this->roleAdapter = new AclAdapter($this->infosyspro->getAdapter());
	$this->adapter = $this->core->getAdapter();
	$this->getAclRoles();
	
	//check  if user is authenticated
	$this->initRoles(); // get roles order does matter
	$this->initResources(); //ge resources assigned to those roles
	$this->initPrivileges(); // Get the view, edit, create etc
	/* By default admins have full access to everything */
	$this->acl->addRole('superAdmins');
	$this->acl->allow('superAdmins');
	
    }

    /**
     * Set ACL table staff or debtors
     */
    public function setTable($table = false)
    {
	if($table == self::ACLDRTABLE || $table == self::ACLSTAFFTABLE) {
	    $this->aclTable = $table;
	} else {
	    //default to debtors table if the table is wrong or not defined
	    $this->aclTable = self::ACLDRTABLE;
	}
    }
    /**
     * The Idea is to add a new resource if there is a group set for this resource
     * This should be called when inserting, deleting or updating data
     * 
     * @params array $options
     * @return bool true|false
     */
    public function setAcl(Array $rawData)
    {
	foreach ($rawData as $k => $acl) {
	    //check if the resource exists
	    if ($this->acl->hasRole($acl['access_group'])) {
		if ($acl['access_group'] == 'all') {//remove the resource form the db
		    $this->deleteAcl($acl['resource'], $acl['access_group']);
		} else { //update the DB
		    $this->updateAcl($acl['resource'], $acl['access_group']);
		}
	    } elseif ($acl['access_group'] != 'all') {//do nothing if group = public
		//insert new role
		$this->addAcl($acl['resource'], $acl['access_group']);
	    }
	}
	return false;
    }

    /**
     * Here the idea is to check if the resource needs to be added.
     * The base filter here is that if the group is set to all = public 
     * don't added it to the acl. We will treat it differently
     * if (in_array($acl['accessGroup'], $userGroups))
     * @param array $options
     * @return boolean
     */
    public function authorise(Array $rawData, $privilege)
    {
	$userGroups = $this->core->getUsers()->getUserGroups();
	if (!$userGroups) { //try to accommodate for guest
	    $userGroups = array(); // make the compiler happy
	}
	foreach ($rawData as $k => $acl) {
	    $allowed = false; //deny by default
	    if ($acl['access_group'] == 'all') {//do nothing if group = public
		continue;
	    }

	    foreach ($userGroups as $key => $group) { //handle user multiple groups
		if ($group == $acl['access_group'] &&
			$this->isAllowed($acl['access_group'], $acl['resource'], $privilege)
		) {
		    $allowed = true;
		    break; //no further questions your honour
		}
	    }
	    if ($allowed) {
		continue; //$allowed flag has been set so don't remove
	    }
	    //the user has no access so remove the element from the array
	    // OR deny the user by default
	    unset($rawData['$k']);
	}
	return $rawData;
    }

    /**
     * Query the acl to check if user is allowed to access a resource
     * @param string $group
     * @param string $resource
     * @param string $privilege
     * @return boolean
     */
    public function isAllowed($group, $resource, $privilege)
    {

	if ($this->acl->hasRole($group) && $this->acl->hasResource($resource)) {
	    return $this->acl->isAllowed($group, $resource, $privilege);
	}
	return false;
    }

    protected function addAcl($name, $group)
    {
	//get the 
	$roleid = $this->getRoleIdByName($group);
    }

    protected function updateAcl($name, $group)
    {
	//get resource id
	$id = $this->getResourceIdByName($name, $group);
	if ($id) {
	    QuickSQL::update("UPDATE TbAclRolesResources SET acl_role_id=" . (int) $id['roleid'] .
		    " WHERE id = " . (int) $id['roleresourceid'], $this->lib->getAdapter());
	}
    }

    public function deleteAcl($name, $group)
    {
	$id = $this->getResourceIdByName($name, $group);
	if ($id) {
	    QuickSQL::delete("DELETE FROM TbAclRolesResources WHERE id = " . (int) $id['roleresourceid'], $this->lib->getAdapter());
	    QuickSQL::delete("DELETE FROM TbAclResources WHERE id = " . (int) $id['resourceid'], $this->lib->getAdapter());
	}
    }

    /**
     * Get roles from the database and assign them to the acl manager
     * Resources will be derived from the group_actions field
     * 
     * @return boolean|\Infosyspro\Acl\AclManager
     */
    public function getAclRoles()
    {
	//check if we have the adapter and it is the correct one
	if (!$this->adapter instanceof \Zend\Db\Adapter\Adapter) {
	    return false;
	}
	
	//query the db
	$table = new Sql($this->adapter, $this->aclTable);
	$select = $table->select();
	$select->order('lft asc');
	$statement = $table->prepareStatementForSqlObject($select);
	$data = $statement->execute();
	
	foreach ($data as $role) {
	    $row = '';
	    //check if we have the parent id set for this role
	    //the parent id means that this role inherits some roles from
	    // another role
	    if ((int) $role['parentid']) {
		$row = $this->find($this->aclTable, array(self::PRIMARYKEY => $role['parentid']));
		$this->aclRoles[$role[self::PRIMARYKEY]]['parent'] = $row['name'];
	    }
	    //add to the stack
	    $this->aclRoles[$role[ self::PRIMARYKEY ]]['name'] = $role['name'];
	    //process resources for this roles and add them to the stack
	    $this->processAclResources($role, $row['name']);
	}

	return $this;
    }

    /**
     * Perfom acl resources this is derived from grouop action field 
     * as the keys of the json object
     * @param array $data
     * @param string $inheritsFromRoleName
     * @return boolean
     */
    protected function processAclResources($data, $inheritsFromRoleName)
    {
	//get array assoc
	$resources = json_decode($data['group_actions'], true);
	if (!$resources)
	    return false;
	$i = 0;
	foreach ($resources as $resource => $privilege) {

	    //Check for ingeritance .. this should be done by double __
	    if (strpos($resource, '__') !== false) {
		$inherits = explode('__', $resource);
		//Asign the first part to the parent
		$this->aclResources[$i]['parent'] = $inherits[0];
		$resource = $inherits[1];
	    }
	    $this->processAclPrivileges($data, $resource, $privilege, $inheritsFromRoleName);
	    //add to the stack	   
	    $this->aclResources[$i]['name'] = $resource;

	    $i++;
	}
    }
    
    /**
     *  Add privileges to the resources derived from the json object
     *  grou_action field
     *  expected outcome array (resource => cms, role => admin , privilege => view)
     * @param string $role
     * @param string $resource
     * @param array $privileges
     * @param string $inheritsFromRoleName
     */
    protected function processAclPrivileges($role, $resource, $privileges, $inheritsFromRoleName = '')
    {
	
	foreach ($privileges as $privilege => $allowed) {
	    $inherited = false;
	    $aclPrivileges['resource'] = $resource;
	    $aclPrivileges['role'] = $role['name'];
	    //check for inheritance
	    if (in_array($inheritsFromRoleName, array_keys($this->aclPrivileges))) {
		// if there is inheritence then don't add repitition
		foreach ($this->aclPrivileges[$inheritsFromRoleName] as $k => $priv) {
		    if ($priv['resource'] == $resource && $priv['privilege'] == $privilege) {
			$inherited = true;
			break;
		    }
		}
	    }
	    // add to stack 
	    if (!$inherited) {
		if ((int) $allowed) {
		    $aclPrivileges['privilege'] = $privilege;
		}

		if (in_array($role['name'], array_keys($aclPrivileges))) {
		    $aclPrivileges[$resource][] = $aclPrivileges;
		} /* elseif (in_array($role['name'], array_keys($this->aclPrivileges))) {

		  // if($aclPrivileges['privilege'] && $aclPrivileges['resource'] == $resource) {
		  $appendPrivs =  $this->aclPrivileges[$role['name']][0];
		  $grouppedPrivs = array();
		  echo $appendPrivs['role'] . ' == ' .  $role['name'] . ' && ' . $appendPrivs['resource'] . '==' . $resource . '<br>';
		  if($appendPrivs['role'] == $role['name'] ) {
		  if (is_string($appendPrivs['privilege'])) {
		  $grouppedPrivs[] = $appendPrivs['privilege'];
		  } else {
		  $grouppedPrivs[]  = array($privilege ) + $appendPrivs['privilege'];


		  }
		  var_dump($grouppedPrivs);
		  $this->aclPrivileges[$role['name']][0]['privilege']= $grouppedPrivs;
		  } else {
		  $this->aclPrivileges[$role['name']][] = $aclPrivileges;
		  }
		  //   var_dump($grouppedPrivs);
		  //   $this->aclPrivileges[$role['name']][$id]['privilege'] = $grouppedPrivs;
		  } */
		else
		    $this->aclPrivileges[$role['name']][] = $aclPrivileges;
	    }
	}
    }

    protected function getResourceIdByName($name, $group)
    {
	$sql = "SELECT are.id as resourceid,aro.id as roleresourceid, ar.id as roleid 
                FROM `TbAclResources`  are
                INNER JOIN TbAclRolesResources aro
                ON acl_resource_id = are.id
                INNER JOIN TbAclRoles ar ON acl_role_id = ar.id 
                WHERE are.name = '$name'  
                AND ar.name = '$group'";
	QuickSQL::processQuery($sql, $this->lib->getAdapter());
	$data = QuickSQL::getResults();
	if (sizeof($data) > 0) {
	    return $data[0];
	}

	return false;
    }

    protected function getRoleIdByName($name)
    {
	QuickSQL::processQuery("SELECT id FROM TbAclRoles WHERE name = '$name'", $this->lib->getAdapter());
	$data = QuickSQL::getResults();
	if (sizeof($data) > 0) {
	    return $data[0]['id'];
	}

	return false;
    }
/**
 *  This is used to add Roles to the registry
 *  Zend throws an error whne trying to add and existing role 
 * Check before adding it to the acl registry
 * 
 * a role is an object that may request access to a Resource.
 */
    protected function initRoles()
    {
	$roles = $this->aclRoles;
	//add roles to the db
	foreach ($roles as $key => $role) {	  
	    if (isset($role['parent'])) {
		$parent = $role['parent'];		
		if (!$this->acl->hasRole($role['parent'])) {
		    // if parent hasn't been created in memory, do so		  
		    $this->acl->addRole($parent);
		}
		//this is how we do inheritance
		$this->acl->addRole($role['name'], $parent);
	    } else {
		// only needs to be done if it doesn't exist
		if (!$this->acl->hasRole($role['name'])) {
		    $this->acl->addRole($role['name']);
		}
	    }
	}
    }
/**
 * a resource is an object to which access is controlled.
 */
    protected function initResources()
    {

	$resources = $this->aclResources;

	 //var_dump($resources);
	foreach ($resources as $key => $resource) {
	    if (isset($resource['parent'])) {
		$parent = null;
		if (!$this->acl->hasResource($resource['name'])) {
		    $parent = $resource['parent'];
		    if (!$this->acl->hasResource($resource['parent'])) {
			$this->acl->addResource($parent);
		    }
		} else {
		    $parent = $this->acl->getResource($resource['name']);
		}
		$this->acl->addResource($resource['name'], $parent);
	    } else {

		if (!$this->acl->hasResource($resource['name'])) {
		    $this->acl->addResource($resource['name']);
		}
	    }
	}
    }

    /**
     * What can the user do when they have the key to a resource
     * @throws Exception
     */
    protected function initPrivileges()
    {
	$privileges = $this->aclPrivileges;	
	foreach ($privileges as $key => $privGroups) {
	    foreach ($privGroups as $privilege) {
		// make sure role and resource are valid
		
		if (isset($privilege['role']) && isset($privilege['resource'])) {
		    $this->acl->allow($privilege['role'], $privilege['resource'], $privilege['privilege']);
		} elseif (isset($privilege['resource'])) {
		    $this->acl->allow(null, $privilege['resource'], $privilege['privilege']);
		} else {
		    throw new Exception('ERROR: Resouce and or Role missing unable to create privilege');
		}
	    }
	}
    }

   
}

