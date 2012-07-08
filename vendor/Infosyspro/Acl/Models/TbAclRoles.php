<?php

/**
 * InfosysPro
 *
 * LICENSE
 *
 * This source file is subject to the Infosyspro license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://infosyspro.com.au/license/software
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@infosyspro.com so we can send you a copy immediately.
 *
 * @category   TbAclRoles
 * @package    Infosyspro_TbAclRoles
 * @subpackage TbAclRoles
 * @copyright  Copyright (c) 2009-2012 Infosyspro. (http://www.infosyspro.com.au)
 * @license    http://infosyspro.com.au/license/software     PRIVATE License
 */
namespace Infosyspro\Acl\Models;

use Zend\Db\TableGateway\TableGateway ,
    Zend\Db\Adapter\Adapter ,
    Zend\Db\ResultSet\ResultSet ;

/**
 * This class handles all TbAclRoles detecttion using php get_browser()
 * 
 */
class TbAclRoles extends TableGateway
{
    
    protected $table = 'TbAclRoles' ;
    protected $tableName = 'TbAclRoles' ;

    public function __construct ( Adapter $adapter = null )
    {
	$this->adapter = $adapter ;
	$this->resultSetPrototype = new ResultSet ( new TableRow ) ;
	$this->initialize () ;
    }

    public function fetchAll ()
    {
        
	$resultSet = $this->select () ;
	return $resultSet ;
    }

    public function find ( $id )
    {
	$id = ( int ) $id ;
	$rowset = $this->select ( array ( 'id' => $id ) ) ;
	$row = $rowset->current () ;
	if ( !$row ) {
	    throw new \Exception ( "Could not find row $id" ) ;
	}
	return $row ;
    }

    public function saveRow ( TableRow $content )
    {
	$data = array (
	    
	) ;
	$id = ( int ) $content->id ;
	if ( $id == 0 ) {
	    $this->insert ( $data ) ;
	} else {
	    if ( $this->getRow ( $id ) ) {
		$this->update ( $data , array ( 'id' => $id ) ) ;
	    } else {
		throw new \Exception ( 'Form id does not exist' ) ;
	    }
	}
    }

    public function addRow ( Array $data )
    {	
	$this->insert ( $data ) ;
    }

    public function updateRow ( Array $data )
    {
	$id = (int) $data['id'];
	
	if (!$id ) return false;
	
	$this->update ( $data , array ( 'id' => $id ) ) ;
    }

    public function deleteRow ( $id )
    {
	$this->delete ( array ( 'id' => $id ) ) ;
    }

}

