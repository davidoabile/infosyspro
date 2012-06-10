<?php

 /**
  * Infosyspro Framework
  *
  * LICENSE
  *
  * This source file is subject to the PRIVATE license that is bundled
  * with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * http://infosyspro.com/license
  * If you did not receive a copy of the license and are unable to
  * obtain it through the world-wide-web, please send an email
  * to support@infosyspro.com so we can send you a copy immediately.
  *
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage BlockCount
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 /**
  * @namespace
  */

 namespace Application\View\Helper;


 /**
  * Class for translating Core statements.
  *
  * @uses       \Zend\Cache\Cache
  * @uses       \Zend\Translator\Translator
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage BlockCount
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 class BlockCount
 {
    protected static $db = null;
    protected static $menuid = 0;
    
     
     public static function countBocks(\Zend\Db\Adapter\Adapter $adapter, $menuId){
        $blocksCount = new \stdClass();
    
        self::$menuid = $menuId;
    
        $sql = "SELECT position, module, params FROM TbBlocks tb
                INNER JOIN TbBlocksMenu tbm ON tb.id = tbm.blockid
                WHERE published = 1 AND menuid = '$menuId'
                ORDER BY tb.position ASC";
   
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $row = $result->getResource();
          
       $blocksCounts = $row->fetchAll(\PDO::FETCH_OBJ);
    
       $blockCount = 0;
       $tempBlock = '';
       
        foreach ( $blocksCounts as $k => $block ) {            
            
            if($tempBlock == $block->position) {               
                $blocksCount->{$block->position}  = ++$blockCount;
            } else {
                $tempBlock = $block->position;
                $blockCount = 1;
                $blocksCount->{$block->position} = $blockCount;
            }
            
            $options = $block->position . '_' . $block->module;
            $blocksCount->{$options} = json_decode($block->params);
        }
    
        return $blocksCount;
     }
 }

 