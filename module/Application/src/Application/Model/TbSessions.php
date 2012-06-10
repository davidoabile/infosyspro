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

class TbSessions extends TableGateway
{

    protected $table = 'TbSessions' ;
    protected $tableName = 'TbSessions' ;

    public function __construct ( Adapter $adapter = null )
    {
	$this->adapter = $adapter ;
	$this->resultSetPrototype = new ResultSet ( new Content ) ;
	$this->initialize () ;
    }

 

}