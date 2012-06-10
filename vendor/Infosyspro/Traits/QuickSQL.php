<?php

namespace Infosyspro\Traits;

/**
 * Description of QuickSQL
 *
 * @author infosyspro
 */
class QuickSQL {

    protected static $results;
    protected static $count;

    public static function processQuery($sql, $adapter, $fetchMode = '') {
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $row = $result->getResource();
        $fetchMode = (!empty($fetchMode)) ? $fetchMode : \PDO::FETCH_OBJ;
        self::$results = $row->fetchAll($fetchMode);
        self::$count = $result->getAffectedRows();

    }

    public static function update($sql, $adapter)
    {
    	$statement = $adapter->createStatement($sql);
    	$result = $statement->execute();    	
    	self::$count = $result->getAffectedRows();
    	 
    }
    
    public static function delete($sql, $adapter)
    {
    	$statement = $adapter->createStatement($sql);
    	$result = $statement->execute();    	    	
    	self::$count = $result->getAffectedRows();
    	 return $result->getAffectedRows();
    }
    
    
    public static function getResults() {
        return self::$results;
    }

    public static function getCount() {
        return self::$count;
    }

}

?>
