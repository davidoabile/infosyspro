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

use Zend\Acl\Acl as ZendAcl,
 Infosyspro\InfosysproLib;

/**
 * Class for performing permissions.
 *
 * @uses       \Zend\ACL
 * @subpackage Adapter
 * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
 * @license    http://infosyspro.com/license     New Infosyspro License
 * @author    David Oabile <doabile@infosyspro.com.au>
 * 
 */
class AclManager {

    protected $acl = null;

    /**
     *
     * @var object AclAdapter object
     */
    protected $roleAdapter = null;

    /**
     * Organise ACLs from the database
     * 
     * @param \Zend\Db\Adapter\Adapter $adapter   
     */
    public function __construct(InfosysproLib $company) {
        
        $this->acl = new ZendAcl();
	$this->roleAdapter = new AclAdapter($company->getAdapter());
        
        //check  if user is authenticated
        $this->initRoles(); // get rolese order does matter
        $this->initResources(); //ge resources assigned to those roles
        $this->initPrivileges(); // Get the view, edit, create etc
        /* By default admins have full access to everything */
        //$this->acl->addRole('superAdmins');
       // $this->acl->allow('superAdmins');    
    $company->getSession()->setKey('acl', $this);
    
        
    }

    public function isAllowed($group, $resource, $privilege) {
        
        if ($this->acl->hasRole($group) && $this->acl->hasResource($resource)) {
            return $this->acl->isAllowed($group, $resource, $privilege);
        }
        return false;
    }

   
    protected function initRoles() {
        $roles = $this->roleAdapter->getAclRoles();       
        foreach ($roles as $key => $role) {            
            if (isset($role['parent'])) {
                $parent = null;
                if (!$this->acl->hasRole($role['parent'])) {
                    // if parent hasn't been created in memory, do so
                    $parent = $role['parent'];
                    $this->acl->addRole($parent);
                }
                $this->acl->addRole($role['name'], $parent);
            } else {
                // only needs to be done if it doesn't exist
                if (!$this->acl->hasRole($role['name'])) {
                    $this->acl->addRole($role['name']);
                }
            }
        }
    }

    protected function initResources() {
        $resources = $this->roleAdapter->getAclResources();   
        var_dump($resources);
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

    protected function initPrivileges() {
        $privileges = $this->roleAdapter->getAclRolesResources();
        foreach ($privileges as $key => $privilege) {
            // make sure role and resource are valid
            if (isset($privilege['role']) && isset($privilege['resource'])) {
                $this->acl->allow($privilege['role'], $privilege['resource'], $privilege['privilege']);
            } else {
                throw new Exception('ERROR: Resouce and or Role missing unable to create privilege' );
            }
        }
    }

}

