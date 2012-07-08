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
  * @subpackage Blocks
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 /**
  * @namespace
  */

 namespace Infosyspro\Sticky;


 /**
  * Class for translating Core statements.
  *
  * @uses       \Zend\Cache\Cache
  * @uses       \Zend\Translator\Translator
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage Blocks
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 class Blocks extends AbstractSticky
 {

     protected $mainModulesBlocks = array(
         'topBlock' => array('user1', 'user2', 'user3'),
         'middleMain' => array('user4', 'user5', 'user6'),
         'bottomMain' => array('user7', 'user8', 'user9'),
         'bottomLow' => array('bottom', 'bottom2', 'bottom3'),
         'case5' => array('showcase', 'showcase2', 'showcase3')
     );

     
     public function getToolbar()
     {
        // $noodle = '<div id="home-button"><a class="home-button-desc" href="/">Home</a></div>';
        // $noodle .= '<div id="login-button"><a class="login-button-desc" href="#"><span>Login</span></a></div>';
         return '';
     }

     public function getNewsFlash()
     {
         return false;
     }

    
     public function getBreadcrumb()
     {
         return '<a class="pathway" href="/">Home</a>/ Features';
     }

    
     public function getBottomMenu()
     {
         
     }

     public function getScroller()
     {
         
     }
     
     public function getLogo()
     {
         return false;
     }
     
     public function  getUserTopMenu() {
            return $this->_getDataFromDb(array('fields' => 'content',
                                            'table' => 'TbBlocks',
                                            'where' => 'WHERE position="userTopMenu" AND published=1'
                                     ));
     }
     
     public function getTopMenu() {
         return $this->_getDataFromDb(array('fields' => 'content',
                                            'table' => 'TbBlocks',
                                            'where' => 'WHERE position="topMenu" AND published=1'
                                     ));
     }
     
     
     public function getShoppingCart()
     {
          //<div id="cart-button"><a href="#" class="cart-button-desc<?php echo $cart; ">
         // $this->lang->translate('cart') .' ' . $totalString; </a></div>
         return false;
     }
     public function getBlock(Array $options)
     {
          if($this->menuid === null) {
             return false;
         }
        
         if (isset($options['style']) && $options['style'] == 'main')
             return $this->_getBlockMain($options);
         else
             return $this->_getBlockContent($options);
     }

     /**
      * Get block contents from the database
      * 
      * @param string $blockName 
      * 
      * @return string $content
      */
     protected function _getBlockContent($options)
     {
         $content = '';
         $data = '';
         if (!array_key_exists('name', $options)) {
             return 'Block name not set';
         }

         $blocks = $this->_getData($options);

         foreach ($blocks as $k => $block) {
             $contents ='';
              
             $data .= '<div class="color1"><div class="side-mod">';

             if (isset($block->showtitle)  && $block->showtitle == 1) {
                 $data .= '<h3 class="module-title"><span>' . @$block->title . '</span></h3>';
             }
             $contents = $block->content;
             /* Render block defined classes */
              if (isset($block->module)) {
                 $name = 'Infosyspro\\AbstractBlocks\\' . $block->module;
                 if (class_exists($name)) {
                     if (method_exists($name, 'render')) {                         
                         $moduleData = $name::render($this->locator); 
                          $moduleData['tpl'] = $block->content;
                          $process = new ModuleBlocks($moduleData);
                          $contents .= $process->render();
                      //    var_dump($moduleData); exit;
                     }
                 }
             }
             if (@$block->contentOrder == 1) {
                 $data .= ' <div class="module"><span>' . $contents . '</span></div></div></div> ';
             } else {
                 $data .= ' <div class="module"><span>' . $contents . '</span></div></div></div> ';
             }
         }
         $content .= $data;

         return $content;
     }

     /**
      * Get block contents from the database
      * 
      * @param string $blockName 
      * 
      * @return string $content
      */
     protected function _getBlockMain($options)
     {
         $content = '';
         $contents = '';
         $data = '';
         $i = 1;
         if (!array_key_exists('name', $options) && !array_key_exists($options['name'], $this->mainModulesBlocks)) {
             return 'Block name not set';
         }

         $blocks = $this->_getData($options, true);
         $num = count($blocks);

         foreach ($blocks as $k => $block) {


             if ($i == 1) {
                 $data .= '<div class="block first">';
             } elseif ($i == $num) {
                 $data .= '<div class="block last">';
             } else {
                 $data .= '<div class="block">';
             }
             $data .= '<div class=""><div class="moduletable">';

             if ($block->showtitle == 1) {
                 $data .= '<h3 class="module-title"><span>' . $block->title . '</span></h3>';
             }
             $contents = $block->content;
             /* Render block defined classes */
             if (isset($block->module)) {
                 $name = 'Infosyspro\\Blocks\\' . $block->module;
                 if (class_exists($name)) {
                     if (method_exists($name, 'render')) {                         
                         $moduleData = $name::render($this->locator); 
                          $moduleData['tpl'] = $block->content;
                     }
                 }
             }

             $data .= $contents . '</div></div></div> ';

             $i++;
         }
         $content .= $data;

         return $content;
     }

     protected function _getData($options, $in = false)
     {
         $blocksCount = new \stdClass();
         $where = '';
         
         if (empty($in)) {
             $where = " AND position = '{$options['name']}'";
         } else {
            $in = implode("','", $this->mainModulesBlocks[$options['name']]);
            $where = " AND position IN('{$in}')";
         }
       
         $sql = "SELECT position, title, content, showtitle, params FROM TbBlocks tb
                INNER JOIN TbBlocksMenu tbm ON tb.id = tbm.blockid
                WHERE published = 1 AND menuid = '{$this->menuid}' {$where}
                ORDER BY tb.position ASC";
 
         \Infosyspro\Traits\QuickSQL::processQuery($sql, $this->db);
       
       
         return \Infosyspro\Traits\QuickSQL::getResults();
     }
     
     protected function _getDataFromDb(array $options)
     {
         
          $adapter = $this->db;
          if(empty($options['fields']) || empty($options['table'])) 
              return false;
         
          $where = !empty($options['where']) ? $options['where'] : '';
          $order = !empty($options['order']) ? $options['order'] : '';
        
          $sql = 'SELECT ' . $options['fields'] . ' FROM ' . $options['table']
                 . ' ' . $where . ' ' . $order;
 
       //   echo $sql; exit;
        \Infosyspro\Traits\QuickSQL::processQuery($sql, $this->db);
       
       
         $data = \Infosyspro\Traits\QuickSQL::getResults();
       
        $contents = '';
        
       if(sizeof($data) > 0 ) {
        /* Render block defined classes */
	   if(isset($data->content))   $contents = $data->content;
        
              if (!empty($data->module)) {
                 $name = 'Infosyspro\\AbstractBlocks\\' . $data->module;
                 if (class_exists($name)) {
                     if (method_exists($name, 'render')) {                         
                         $moduleData = $name::render($this->locator); 
                          $moduleData['tpl'] = $data->content;
                          $process = new ModuleBlocks($moduleData);
                          $contents .= $process->render();
                      //    var_dump($moduleData); exit;
                     }
                 }
             }
       }
         return $contents;
       
     }

     
 }

 