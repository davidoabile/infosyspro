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
class AclAdapter {

 protected $adapter;
    
  public function __construct(\Zend\Db\Adapter\Adapter $adapter)
  {
      $this->adapter = $adapter;
  }
  
  
  public function getAclRoles() 
  {
      if(!$this->adapter instanceof \Zend\Db\Adapter\Adapter){
	  return false;	  
      }
        $result = array();
	$table = new Models\TbAclRoles($this->adapter); 
     
      $data = $table->fetchAll();
      foreach ($data as $role) {
          if ($role->inheritsFrom_id) {
              $row = $table->find($role->inheritsFrom_id);              
              $result[$role->id]['parent'] = $row->name; 
          }
          $result[$role->id]['name'] = $role->name;
      }
      return $result;
  }
  
  public function getAclResources()
  {
      if(!$this->adapter instanceof \Zend\Db\Adapter\Adapter){
	  return false;	  
      }
        $result = array();
      $table = new Models\TbAclResources($this->adapter);      
      $data = $table->fetchAll();
      foreach ($data as $role) {
          if ($role->inheritsFrom_id) {
              $row = $table->find($role->inheritsFrom_id);
              $result[$role->id]['parent'] = $row->name; 
          }
          $result[$role->id]['name'] = $role->name;
      }
      return $result;
  }
  
  public function getAclRolesResources()
  {
      if(!$this->adapter instanceof \Zend\Db\Adapter\Adapter){
	  return false;	  
      }
      
       $result = array();
      $table = new Models\TbAclRolesResources($this->adapter);
      $tbAclRoles = new Models\TbAclRoles($this->adapter);
      $tbAclResources = new Models\TbAclResources($this->adapter);
      
      $data = $table->fetchAll();
      foreach ($data as $role) {
          if ($role->acl_resource_id) {
              $row = $tbAclResources->find($role->acl_resource_id);
              $result[$role->id]['resource'] = $row->name; 
          }
          if ($role->acl_role_id) {
             $row = $tbAclRoles->find($role->acl_role_id);
              $result[$role->id]['role'] = $row->name; 
          }
          
          $result[$role->id]['privilege'] = $role->privilege;
      }
      return $result;
  }
}

