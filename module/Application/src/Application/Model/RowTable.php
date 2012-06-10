<?php

/**
 * Infosyspro Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
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

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway,
Zend\Db\Adapter\Adapter,
Zend\Db\ResultSet\ResultSet;

class RowTable extends TableGateway {

    public function __construct($name, Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        return parent::__construct($name, $adapter, $databaseSchema, $selectResultPrototype);
    }

    public function setOptions(Array $dbOptions){
        if(isset($dbOptions['name'])) {
            
            $this->tableName = $dbOptions['name'];
        }
    }
    
    public function fetchAll($whereConditions = array(), Array $tableName = null ) {
       /* if(is_null($where)) {
             $where = new \Zend\Db\Sql\Where(); 
        }
        $resultSet = $this->select();
       // var_dump($resultSet); exit;
        return $resultSet;
        * 
        */
        //set the table
        if($tableName !== null ) {
            $this->setOptions($tableName);
        }
       
        //prepare the where clause
        $where = new \Zend\Db\Sql\Where();
        
        if (count($whereConditions) > 0) {

            foreach ($whereConditions as $predicate => $conditions) {
               
                if ($predicate == 'where') {
                    foreach ($conditions as $condkey => $condition) {
                        $where->literal($condkey . '= ?', $condition);
                    }
                } elseif ($predicate == 'orWhere') {

                    foreach ($conditions as $condkey => $condition) {
                        $where->OR
                               ->literal($condkey . '= ?', $condition);
                    }
                } 
            }
        }
      // echo $where->getSqlString(); exit;
        //$resultSet = $this->select($where);
            return $this->select($where);
            
            
    }
    
      public function fetchRow(Array $filter = null) {
        
        if($filter !== null && !$filter instanceof \Zend\Db\Sql\Where) {  //instantiate the where object
            $where = new \Zend\Db\Sql\Where(); 
            $where->Literal($filter['field'] . ' = ?' , $filter['value']);
        } elseif($filter !== null) {
            $where = $filter; //the where object has already been set
        }
   
        $rowset = $this->select($where);
        $row = $rowset->current();
        
        if (!$row) {
           return false;
        }
        return $row;
    }
    
    public function getRow($filter) {
        
        if(!$filter instanceof \Zend\Db\Sql\Where) {  //instantiate the where object
            $where = new \Zend\Db\Sql\Where(); 
            $where->Literal('id = ?' , $filter);
        } else {
            $where = $filter; //the where object has already been set
        }
        
        $rowset = $this->select($where);
        $row = $rowset->current();
        
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function addRow(Array $data) {
        
        $this->insert($data);
    }

    public function updateRow(Array $data) {
        if(!isset($data['id'])) {
             throw new \Exception('ID must be set in order to update a row');
        }
        $this->update($data, array('id' => $data['id']));
    }

    public function deleteRow($id) {
        $this->delete(array('id' => $id));
    }

    
}