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

use Zend\Acl as ZendAcl,
        Zend\Db\Table\Table as ZendTable;

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

 protected $table;
    
  public function __construct(ZendTable $dbAdapter)
  {
      $this->table = $dbAdapter;
  }
  
  public function setDbAdapter($adapter)
  {
      $this->table = $dbAdapter;
  }
  
  public function getAclRoles($config = array('name' => 'TbAclRoles')) 
  {
       return $this->getAcl($config);
  }
  
  public function getAclResources($config = array('name' => 'TbAclResources'))
  {
       return $this->getAcl($config);
  }
  
  public function getAclRolesResources($config = array('name' => 'TbAclRolesResources'))
  {
       return $this->_getRoleResource($config);
  }
  
  protected function getAcl($config)
  {
      $result = array();
      
      $this->table->setOptions($config);
      $data = $this->table->fetchAll();
      foreach ($data as $role) {
          if ($role->inheritsFrom_id) {
              $row = $this->table->find($role->inheritsFrom_id);
              $result[$role->id]['parent'] = $row[0]->name; 
          }
          $result[$role->id]['name'] = $role->name;
      }
      return $result;
  }
  
   protected function _getRoleResource($config)
  {
      $result = array();
      
      $this->table->setOptions($config);
      $table = clone $this->table;
      
      $data = $this->table->fetchAll();
      foreach ($data as $role) {
          if ($role->acl_resource_id) {
              $table->setOptions(array('name' => 'TbAclResources'));              
              
              $row = $table->find($role->acl_resource_id);
              $result[$role->id]['resource'] = $row[0]->name; 
          }
          
          if ($role->acl_role_id) {
              $table->setOptions(array('name' => 'TbAclRoles'));              
              
              $row = $table->find($role->acl_role_id);
              $result[$role->id]['role'] = $row[0]->name; 
          }
          
          $result[$role->id]['privilege'] = $role->privilege;
      }
      return $result;
  }
  
}

