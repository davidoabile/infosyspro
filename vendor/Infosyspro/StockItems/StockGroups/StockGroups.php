<?php

  /*
   * To change this template, choose Tools | Templates
   * and open the template in the editor.
   */
namespace StockItems\StockGroups;
  /**
   * Description of StockGroups
   *
   * @author infosyspro
   */
  class StockGroups extends AbstractStockItems
  {
      protected $parentGroup = null;
      /**
       * Get groups from the database
       * 
       * Groups can be from different types from the db 
       * So groupType and clientid should be passed
       * 
       * @param array $options
       * @return array groups and children 
       */
      public function getGroups($options = array('groupType' => 'stockItems', 'clientid' => 0))
      {
           $table = $this->_getDbTable();
         
          $this->table->setOptions(array('name' => 'TbSTOCK_ITEMS_CATEGORIES'));
          $categories =   $table->fetchAll($table->select()
                                                 ->where('CATEGORY_TYPE = ?', $options['groupType'])
                                                 ->where('CLIENT_ID = ?', $options['clientid'])
                                                 ->order('LEVEL ASC')
                                            );    
          $this->parentGroup = $categories;
          $groups = array();
          
          foreach($categories as $group => $category) {
              if($category->LEVEL > 1) {
                  $children = $this->getChildren($catetory->PARENT_ID);
                  if(sizeof($children) > 0) {
                      $groups[$catetory->PARENT_ID][$catetory->ID] = $children;
                  }
              } else {
                  $groups[$catetory->ID][] = $category;
              }
              
            
          }
          return $groups;
      }
      
      /* This $i will be used to get children 
           * It is assumed that menu levels will start from 1
           */
      protected function getChildren($id) {
           reset($this->parentGroup);
           $childrenGroups = array();  
          
          foreach($children as $group => $child) {
              if($child->PARENT_ID == $id && $child->LEVEL == $i){
                   $childrenGroups[$child->ID] = $child; 
                   $hasChildren = $this->getGrandChildren($child->PARENT_ID);
                  do{
                     
                      if(sizeof($hasChildren) > 0) {  
                        $childrenGroups[$child->PARENT_ID][$child->ID] =  $hasChildren; 
                         $hasChildren = $this->getGrandChildren($child->ID);
                      }
                   } while (!$hasChildren);
              }
             
              $i++;
          }
          
          return $childrenGroups;
      }
      
      protected function getGrandChildren($id, $level) 
      {
          $grandChildrenGroups = array();  
          reset($this->parentGroup);
          
          foreach($this->parentGroup as $group => $child) {
              if($child->PARENT_ID == $id ){
                   $grandChildrenGroups[$child->ID] = $child;                  
              }
          }
          
          return $grandChildrenGroups;
      }
  }

