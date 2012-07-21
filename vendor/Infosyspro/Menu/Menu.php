<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Infosyspro\Menu ;

use Infosyspro\Traits ;

class Menu extends \Infosyspro\AbstractRestFul
{

    protected $model = null ;

    public function init ()
    {
	$this->model = new MenuModel( $this->infosyspro->getAdapter() ) ;
    }

    public function listMenu ()
    {
	$menu = $this->_getQuery( 'SELECT id,title as text,lft,rgt,leaf FROM TbMenu ORDER BY lft asc' ) ;
	// convert list result set to nested tree structure.
	// create a dummy root node that will be the base of our tree structure
	$root = array(
	    // all nodes in the result set should fall within these left/right bounds
	    'lft' => 0,
	    'rgt' => PHP_INT_MAX,
	    'children' => array( )
		) ;

	$listStack = array( &$root ) ;
	$listCount = count( $menu ) ;
	for ( $i = 0 ; $i < $listCount ; $i++ ) {
	    $list = &$menu[ $i ] ;

	    $parent = &$listStack[ count( $listStack ) - 1 ] ;
	    //array(3) { ["lft"]=> int(0) ["rgt"]=> int(9223372036854775807) ["children"]=> array(0) { } } 
	    while ( $list[ 'rgt' ] > $parent[ 'rgt' ] ) {
		// if the current list is not a child of parent, pop lists off the stack until we get to a list that is its parent
		array_pop( $listStack ) ;
		$parent = &$listStack[ count( $listStack ) - 1 ] ;
	    }
	    // add the node to its parent node's "children" array
	    $parent[ 'children' ][ ] = &$list ;

	    if ( $list[ 'rgt' ] - $list[ 'lft' ] > 2 ) { // if the node has children
		$list[ 'expanded' ] = 1 ; // nodes that have children are expanded by default
		$list[ 'children' ] = array( ) ;
		$listStack[ ] = &$list ; // push the node on to the stack
	    } else if ( empty( $list[ 'leaf' ] ) ) {
		// for non leaf nodes that do not have any children we have to set "loaded" to true
		// This prevents the TreeStore from trying to dynamically load content for these nodes when they are expanded
		$list[ 'loaded' ] = 1 ;
		unset( $list[ 'leaf' ] ) ; // no need to return "leaf: null" to the client for non leaf nodes
	    }
	}
	$this->_removeTreeProperties( $root ) ;

	return $this->_results( $root ) ;
    }

    public function listGridMenu ( $query )
    {
	$limit = (( int ) $query[ 'limit' ] > 0 ) ? $query[ 'limit' ] : 20 ;
	$start = (( int ) $query[ 'start' ] > -1 ) ? $query[ 'start' ] : 0 ;
	$order = ' ORDER BY ' . $query[ 'sort' ] . ' ' . $query[ 'dir' ] ;
        if(isset($query['id'])) {
	    $id = (int) $query['id'];
	    $parent = array_pop( $this->_getQuery( 'SELECT lft,rgt FROM TbMenu WHERE id =' . $id )) ;

            $sql = 'SELECT * FROM TbMenu WHERE lft >= ' . $parent['lft'] . ' AND rgt  <= ' . $parent['rgt'] . ' AND leaf = 1  ORDER BY lft asc' ;
        } else $sql ='SELECT * FROM TbMenu WHERE parentId = 1 AND leaf = 1 ORDER BY lft asc' ;
	//echo $sql; exit;
	return $this->_getQuery( $sql ) ;
    }

    public function createTree ( $data )
    {

	$adapter = $this->infosyspro->getAdapter() ;
	$db = $adapter->getDriver()->getConnection() ;
	$db->beginTransaction() ;
	if ( ( int ) $data[ 'parentid' ] > 0 ) {
	    $parent = array_pop( $this->_getQuery( 'SELECT * FROM TbMenu WHERE id =' . ( int ) $data[ 'parentid' ] ) ) ;

	    // the left bound of the new node is it's parent's right bound (append node to end of parent's child nodes)
	    //$menuType = $parent[ 'menuType' ] ;
	    $leftBound = ( int ) $parent[ 'rgt' ] ;
	    // the right bound of the new node is leftBound + 1, because the new node has no children
	    $rightBound = $leftBound + 1 ;

	    // before we can insert a new node we need to increment by 2 the left and right values for all nodes to the right of where the new node is being inserted
	    $statement = $db->prepare( "UPDATE TbMenu SET lft = lft + 2 WHERE lft >= $rightBound" ) ;
	    // $this->model->update(array('lft' => 'lft + 2'), array('lft' => $rightBound));
	    if ( !$statement->execute() ) {
		$db->rollBack() ;
		throw new Exception( implode( ', ', $statement->errorInfo() ) ) ;
	    }

	    $statement = $db->prepare( "UPDATE TbMenu SET rgt = rgt + 2 WHERE rgt >= $leftBound" ) ;
	    // $this->model->update(array('rgt' => 'rgt + 2'), array('rgt' => $leftBound));
	    if ( !$statement->execute() ) {
		$db->rollBack() ;
		throw new Exception( implode( ', ', $statement->errorInfo() ) ) ;
	    }
	} else {
	    // if there is no parent, append the new node as a root node at the very end
	    $statement = $this->_getQuery( 'SELECT MAX(rgt) AS maxrgt FROM TbMenu' ) ;
	    if ( count( $statement ) > 0 ) {
		// the left bound of the new node is right after the right bound of the node with the highest right bound in the table
		$leftBound = ( int ) $statement[ 'maxrgt' ] + 1 ;
		// the right bound of the new node is leftBound + 1, because the new node has no children
		$rightBound = $leftBound + 1 ;
	    } else {
		//throw new Exception(implode(', ', $statement->errorInfo()));
	    }
	}
	// insert the new list node into the database

	$statement = $db->prepare( "insert into TbMenu (title, leaf, lft, rgt) 
		 values('{$data[ 'name' ]}', " . intval( $data[ 'leaf' ] ) . ", $leftBound, $rightBound)" ) ;
	if ( !$statement->execute() ) {
	    $db->rollBack() ;
	}
	$res[ 'id' ] = $db->getLastGeneratedValue() ;
	$db->commit() ;

	return $res ;
    }
public function updateNode ( array $data )
{
    try {
    $params = json_decode(file_get_contents('php://input'));
var_dump($params); exit;
    $statement = $db->prepare("update list set name = '$params->name' where id = $params->id");

    if(!$statement->execute()) {
        throw new Exception(implode(', ', $statement->errorInfo()));
    }
    $jsonResult = array(
        'success' => true,
        'children' => $params
    );
} catch(Exception $e) {
    $jsonResult = array(
        'success' => false,
        'message' => $e->getMessage()
    );
}
}
    public function moveNode ( $data )
    {
	$adapter = $this->infosyspro->getAdapter() ;
	$db = $adapter->getDriver()->getConnection() ;
	$params = new \stdClass() ;
	foreach ( $data as $k => $v ) {
	    $params->$k = $v ;
	}

	$db->beginTransaction() ;

	// if the node is being appended to the root node, change relatedId and position so that the node will be appended after the last node in the db
	// this is necessary because we do not store the actual root node in the db
	if ( $params->relatedId == -1 ) {
	    $max = $this->_getQuery( "select id from TbMenu where rgt = (select max(rgt) from TbMenu)" ) ;
	    $params->relatedId = $max[ 0 ][ 'id' ] ;
	    $params->position = 'after' ;
	}

	// Step 1: figure out how much space the node to be moved takes up (nodeSize)
	$statement = $this->_getQuery( "select lft, rgt from TbMenu where id = $params->id" ) ;

	$nodeSize = $statement[ 0 ][ 'rgt' ] - $statement[ 0 ][ 'lft' ] + 1 ;

	// Step 2: calculate the insertion point where the node is being moved to.
	// this will be the left bound of the node after it is moved
	$relatedNodeBounds = array_pop( $this->_getQuery( "select lft, rgt from TbMenu where id = $params->relatedId" ) ) ;

	if ( $params->position == 'after' ) {
	    $insertionPoint = $relatedNodeBounds[ 'rgt' ] + 1 ;
	} else if ( $params->position == 'before' ) {
	    $insertionPoint = $relatedNodeBounds[ 'lft' ] ;
	} else if ( $params->position == 'append' ) {
	    $insertionPoint = $relatedNodeBounds[ 'rgt' ] ;
	}

	// Step 3: before moving the node and its descendants, make room at the insertion point
	// this is done by incrementing by nodeSize the left/right values for all nodes to the right of the insertion point
	$statement = $db->prepare( "UPDATE TbMenu SET lft = lft + $nodeSize WHERE lft >= $insertionPoint" ) ;
	if ( !$statement->execute() ) {
	    $db->rollBack() ;
	    throw new \Exception( implode( ', ', $statement->errorInfo() ) ) ;
	}
	$statement = $db->prepare( "update TbMenu set rgt = rgt + $nodeSize where rgt >= $insertionPoint" ) ;
	if ( !$statement->execute() ) {
	    $db->rollBack() ;
	    throw new \Exception( implode( ', ', $statement->errorInfo() ) ) ;
	}

	// Step 4: calculate how far the node has to move to get to the insertion point
	// to do this, we need to first recalculate the node's bounds, since they may have changed in Step 3
	// if the node's existing position is to the right of the insertion point
	$nodeBounds = array_pop( $this->_getQuery( "select lft, rgt from TbMenu where id = $params->id" ) ) ;

	$leftBound = $nodeBounds[ 'lft' ] ;
	$rightBound = $nodeBounds[ 'rgt' ] ;
	$distance = $insertionPoint - $nodeBounds[ 'lft' ] ;

	// Step 5: "move" the node to the insertion point by incrementing by $distance
	// the left/right values for the node being moved and all its descendants
	$statement = $db->prepare( "update TbMenu set lft = lft + $distance, rgt = rgt + $distance where lft >= $leftBound and rgt <= $rightBound" ) ;
	if ( !$statement->execute() ) {
	    $db->rollBack() ;
	    throw new \Exception( implode( ', ', $statement->errorInfo() ) ) ;
	}

	// Step 6: decrement the left/right values for all the nodes to the right of the empty space left by the node that was moved
	$statement = $db->prepare( "update TbMenu set lft = lft - $nodeSize where lft > $rightBound" ) ;
	if ( !$statement->execute() ) {
	    $db->rollBack() ;
	    throw new \Exception( implode( ', ', $statement->errorInfo() ) ) ;
	}
	$statement = $db->prepare( "update TbMenu set rgt = rgt - $nodeSize where rgt > $rightBound" ) ;
	if ( !$statement->execute() ) {
	    $db->rollBack() ;
	    throw new \Exception( implode( ', ', $statement->errorInfo() ) ) ;
	}

	$db->commit() ;
	return array( 'success' => true ) ;
    }

    public function deleteNode ( $data )
    {
	try {
	    $adapter = $this->infosyspro->getAdapter() ;
	    $db = $adapter->getDriver()->getConnection() ;

	    $params = new \stdClass() ;
	    foreach ( $data as $k => $v ) {
		$params->$k = $v ;
	    }

	    $db->beginTransaction() ;

	    // get the left and right bounds of the node so we can delete it and all its descendants
	    $bounds = array_pop($this->_getQuery( "SELECT lft, rgt FROM TbMenu WHERE id = $params->id" )) ;
	    
	    $leftBound = (int)$bounds[ 'lft' ] ;
	    $rightBound = (int)$bounds[ 'rgt' ] ;

	    // delete the node and all its descendants
	    $statement = $db->prepare( "DELETE FROM TbMenu WHERE lft >= $leftBound AND rgt <= $rightBound" ) ;
	    if ( !$statement->execute() ) {
		$db->rollBack() ;
		throw new Exception( implode( ', ', $statement->errorInfo() ) ) ;
	    }

	    // calculate the amount of empty space left after deleting the nodes.
	    $emptySpace = $rightBound - $leftBound + 1 ;

	    // decrement by the empty space amount the lft and rgt values for all nodes that come after the nodes that were deleted.
	    $statement = $db->prepare( "UPDATE TbMenu SET lft = lft - $emptySpace WHERE lft > $rightBound" ) ;
	    if ( !$statement->execute() ) {
		$db->rollBack() ;
		throw new Exception( implode( ', ', $statement->errorInfo() ) ) ;
	    }


	    $statement = $db->prepare( "UPDATE TbMenu SET rgt = rgt - $emptySpace WHERE rgt > $rightBound" ) ;
	    if ( !$statement->execute() ) {
		$db->rollBack() ;
		throw new Exception( implode( ', ', $statement->errorInfo() ) ) ;
	    }

	    $result = array( 'success' => true ) ;
	    $db->commit() ;
	} catch ( Exception $e ) {
	    $db->rollBack() ;
	    $result = array(
		'success' => false,
		'message' => $e->getMessage()
		    ) ;
	}
	return $result ;
    }

    protected function _getQuery ( $sql )
    {
	Traits\QuickSQL::processQuery( $sql, $this->infosyspro->getAdapter(), \PDO::FETCH_ASSOC ) ;
	return Traits\QuickSQL::getResults() ;
    }

    // remove properties that are not needed by the UI (lft and rgt)
    protected function _removeTreeProperties ( &$list )
    {
	unset( $list[ 'lft' ] ) ;
	unset( $list[ 'rgt' ] ) ;
	if ( isset( $list[ 'children' ] ) ) {
	    foreach ( $list[ 'children' ] as &$child ) {
		$this->_removeTreeProperties( $child ) ;
	    }
	}

	return $list ;
    }

    protected function _results ( $data )
    {
	if ( sizeof( $data ) > 0 ) {
	    return array(
		'children' => $data[ 'children' ]
		    ) ;
	}
	return array(
	    'success' => false,
	    'children' => 'Failed to load Menu'
		) ;
    }

}
