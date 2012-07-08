<?php


namespace Infosyspro\Menu ;

use Zend\Db\TableGateway\TableGateway ,
    Zend\Db\Adapter\Adapter ;
   
class MenuModel extends TableGateway
{

    protected $table = 'TbMenu' ;
    protected $tableName = 'TbMenu' ;

    public function __construct ( Adapter $adapter = null )
    {
	$this->adapter = $adapter ;
	//$this->resultSetPrototype = new ResultSet ( new TableRow ) ;
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

    public function selectRow( Array $whereConditions ) {
        
        $select = $this->getSql()->select();
        $where = $select->where;
        
        if (count($whereConditions) > 0) {

            foreach ($whereConditions as $predicate => $conditions) {
               
                if ($predicate == 'where') {
                    foreach ($conditions as $condkey => $condition) {
                        $where->literal($condkey . '= ?', $condition);
                    }
                } else if ($predicate == 'orWhere') {

                    foreach ($conditions as $condkey => $condition) {
                        $where->OR
                               ->literal($condkey . '= ?', $condition);
                    }
                }
            }
        }
        return $this->select($where );
    }
}