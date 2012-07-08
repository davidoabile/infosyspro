<?php

namespace Infosyspro ;

class AbstractRestFul implements RestInterfaceClasses
{

    protected $infosyspro = null ;
    protected $user = null ;

    public function __construct ( \Infosyspro\InfosysproLib $infosyspro )
    {
	$this->infosyspro = $infosyspro ;
	$this->user = $infosyspro->getUsers() ;
        $this->init();
    }

    public function create ( Array $data )
    {
	return $this->_checkMethodIfExists($data);
    }

    /**
     * RESTful delete
     * @param array $locator
     * @param init $id
     * @return boolean 
     */
    public function delete ( $id, Array $data )
    {
	return $this->_checkMethodIfExists($data);
    }

    /**
     * RESTFul GET
     * @param array $locator
     * @param int $id
     * @param array $data
     * @return bool 
     */
    public function get ( $id, Array $data )
    {
	return $this->_checkMethodIfExists($data);
    }

    /**
     * RESTFul PUT
     * @param array $locator
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    public function update ( $id, Array $data )
    {
	return $this->_checkMethodIfExists($data);
    }

    public function getList ( Array $data )
    {
	return $this->_checkMethodIfExists($data);
    }
    
    public function init() {}
    
    protected function _checkMethodIfExists ( $data ) {
	//check which method has been called
	if ( !empty( $data[ 'method' ] ) ) {
	    $method = $data[ 'method' ] ;
	    unset($data[ 'method' ]);
	    if ( method_exists( $this, $method ) ) {
		return $this->$method( $data ) ;
	    }
	}
	return false ;
    }

}