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

 namespace Infosyspro\Session;

use Zend\Session\SaveHandler\DbTableGateway as ZendSessionHandler,
 Zend\Session\SaveHandler\DbTableGatewayOptions,
 Application\Model\TbSessions;

 /**
  * Class for connecting to SQL databases and performing session management.
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
 class UserSessionManager extends  ZendSessionHandler
 {
    // protected $session = null;
     //protected $infosyspro = null;
     
     public function __construct(\Zend\Db\Adapter\Adapter $adapter ) 
     {
        $options = new DbTableGatewayOptions();
	//$options->setNameColumn('userid');
        /* $config = array(
            'name'          => 'TbSessions',
            'primary'       => 'id',
            'modifiedColumn' => 'modified',
            'dataColumn'    => 'data',
            'lifetimeColumn'=> 'lifetime', 
            'db'            => $db ,
          
         );
	 * 
	 */
	//$this->infosyspro = $infosyspro;
	$adpt = new TbSessions($adapter);
         
        parent::__construct( $adpt , $options );
	$this->open(session_save_path() , 'InfosysPro');
    }
    
    public function getSessionId() {
	return session_id();
    }
   
    /**
     * Write session data
     *
     * @param string $id
     * @param string $data
     * @return boolean
     */
   /** public function write($id, $data)
    {
        $return = false;
        $this->read($id);
        
        if(empty($id)) {
            return $return;
        }
        
        $data = array($this->_modifiedColumn => time(),
                      $this->_dataColumn     => (string) $data['data'],
                      'userid'               => (int)$data['userid'],
                      'clientid'             => (int)$data['clientid'],
                      'guest'                => (int)$data['guest'],
                      'username'             => (string)$data['username']);

        $rows = call_user_func_array(array(&$this, 'find'), $this->_getPrimary($id));

        if (count($rows)) {
            $data[$this->_lifetimeColumn] = $this->_getLifetime($rows->current());

            if ($this->update($data, $this->_getPrimary($id, self::PRIMARY_TYPE_WHERECLAUSE))) {
                $return = true;
            }
        } else {
            $data[$this->_lifetimeColumn] = $this->_lifetime;

            if ($this->insert(array_merge($this->_getPrimary($id, self::PRIMARY_TYPE_ASSOC), $data))) {
                $return = true;
            }
        }

        return $return;
    }
    * 
    * @param type $id
    * @param type $data
    * @return type
    */
    
     public function write($id, $data)
    {
	 $data = array($this->options->getModifiedColumn() => time(),
                      $this->options->getDataColumn()     => (string) $data['data'],
                      'userid'               => (int)$data['userid'],
                      'clientid'             => (int)$data['clientid'],
                      'guest'                => (int)$data['guest'],
                      'username'             => (string)$data['username']);
	 
	 
        $rows = $this->tableGateway->select(array(
            $this->options->getIdColumn() => $id,
            $this->options->getNameColumn() => $this->sessionName,
        ));

        if ($row = $rows->current()) {
            return (bool) $this->tableGateway->update($data, array(
                $this->options->getIdColumn() => $id,
                $this->options->getNameColumn() => $this->sessionName,
            ));
        }
	
        $data[$this->options->getLifetimeColumn()] = $this->lifetime;
        $data[$this->options->getIdColumn()] = $id;
        $data[$this->options->getNameColumn()] = $this->sessionName;

        return (bool) $this->tableGateway->insert($data);
    }

 }

 