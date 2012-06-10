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

 namespace Infosyspro\Sticky;



 /**
  * Class for connecting to SQL databases and performing common operations.
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
 class Toolbar extends AbstractSticky
 {
     protected $toolbar = array(
         
         'save'      => array(
                             'id' => 'toolbar-apply',
                             'class'   => 'apply',
                             
                        ),
         'saveAndClose'     => array(
                             'id' => 'toolbar-save',
                             'class'   => 'save',
                           
                        ),  
         'cancel'      => array(
                             'id' => 'toolbar-cancel',
                             'class'   => 'cancel',
                           
                        ),  
         'help'      => array(
                             'id' => 'toolbar-help',
                             'class'   => 'help',
                            
                        ),  
         'new'      => array(
                             'id' => 'toolbar-new',
                             'class'   => 'new',
                            
                        ),  
         'edit'      => array(
                             'id' => 'toolbar-edit',
                             'class'   => 'edit',
                            
                        ),  
         'publish'      => array(
                             'id' => 'toolbar-publish',                          
                             'class'   => 'publish',
                           
                        ),  
         'unpublish'      => array(
                             'id' => 'toolbar-unpublish',                           
                             'class'   => 'unpublish',                           
                        ),  
         'featured'      => array(
                             'id' => 'toolbar-featured',                           
                             'class'   => 'featured',                           
                        ),  
          'trash'      => array(
                             'id' => 'toolbar-trash',                         
                             'class'   => 'trash',                           
                        ),  
         
     );
     
     public function toolbar(Array $options )
     {
       
         ob_start();
        ?> 
         
          <div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
                                 <ul>       
                                <?php                            
                                 foreach($options as $tbar ) : 
                                     if(array_key_exists($tbar, $this->toolbar)) :
                                 ?>
                                    
                                     <li class="button" id="<?php echo $this->toolbar[$tbar]['id'] ?>">
                                    <a href="#" onclick="<?php echo sprintf("submitFormProcess('%s', '%s')", $this->toolbar[$tbar]['id'], $options['formID']) ?>" class="toolbar">
                                    <span class="icon-32-<?php echo $this->toolbar[$tbar]['class'] ?>">
                                    </span>
                                    <?php echo $tbar ?>
                                    </a>
                                    </li>
                                 <?php   
                                    endif;
                                endforeach;
           ?>
            </ul>
                <div class="clr"></div>
                <div class="clr"></div>
                </div>

                <div class=" pagetitle icon-48-<?php echo $options['class'] ?>"><h2><?php echo $options['pagetitle'] ?></h2></div>
                </div>
                </div>
              <?php
               
           unset($options);                         
           $contents = ob_get_contents();
           ob_clean();
           
           return $contents;
     }
 }

 