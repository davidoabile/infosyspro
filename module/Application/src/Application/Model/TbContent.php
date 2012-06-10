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

namespace Application\Model ;

use Zend\Db\TableGateway\TableGateway ,
    Zend\Db\Adapter\Adapter ,
    Zend\Db\ResultSet\ResultSet ;

class TbContent extends TableGateway
{

    protected $table = 'TbContent' ;
    protected $tableName = 'TbContent' ;

    public function __construct ( Adapter $adapter = null )
    {
	$this->adapter = $adapter ;
	$this->resultSetPrototype = new ResultSet ( new Content ) ;
	$this->initialize () ;
    }

    public function fetchAll ()
    {
	$resultSet = $this->select () ;
	return $resultSet ;
    }

    public function getRow ( $id )
    {
	$id = ( int ) $id ;
	$rowset = $this->select ( array ( 'id' => $id ) ) ;
	$row = $rowset->current () ;
	if ( !$row ) {
	    throw new \Exception ( "Could not find row $id" ) ;
	}
	return $row ;
    }

    public function saveRow ( Content $content )
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