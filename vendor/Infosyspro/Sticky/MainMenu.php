<?php

 /**
  * Infosyspro Framework
  *
  * LICENSE
  *
  * This source file is subject to the new private license that is bundled
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
 class MainMenu extends AbstractSticky
 {
      public function init()
      {
          $menuNodes = array('Site'=>  array( array(
                                                            'class' =>  'icon-16-cpanel',
                                                            'link' => '/',
                                                            'title' =>'Control Panel',
                                             ),
                                        array(
                                                            'class' =>  'icon-16-config',
                                                            'link' => '/',
                                                            'title' =>'Global Configuration',
                                            ),
                                        array(
                                                            'class' =>  'icon-16-maintenance',
                                                            'link' => '/',
                                                            'title' =>'Maintenance',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-checkin',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-checkin',
                                                                                                'id' => 'menu-com-checkin',
                                                                                                'link' => '/',
                                                                                                'title' =>'Global Check-in',
                                                                                                ),
                                                                                                array(
                                                                                                    'class' =>  'icon-16-clear',                                                                    
                                                                                                    'link' => '/',
                                                                                                    'title' =>'Clear Cache',
                                                                                                ),
                                                                                                array(
                                                                                                    'class' =>  'icon-16-purge',                                                                    
                                                                                                    'link' => '/',
                                                                                                    'title' =>'Purge Expired Cache',
                                                                                                ),
                                                                                    ),
                                                                ),
                                            ), 
                                            array(
                                                   'class' =>  'icon-16-info',                                                                    
                                                   'link' => '/',
                                                   'title' =>'System Information',
                                            ),
                                             array(
                                                   'class' =>  'icon-16-logout',                                                                    
                                                   'link' => '/',
                                                   'title' =>'Logout',
                                            ),
                                  ), 
         
                        'Users'=>  array( array(
                                                            'class' =>  'icon-16-user',
                                                            'link' => '/',
                                                            'title' =>'User Manager',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-users-users',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New User',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                            array(
                                                            'class' =>  'icon-16-groups',
                                                            'link' => '/',
                                                            'title' =>'Groups',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-users-users',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Group',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                            array(
                                                   'class' =>  'icon-16-massmail',                                                                    
                                                   'link' => '/',
                                                   'title' =>'Mass Mail Users',
                                            ),
                                  ),          
                       'Menus'=>  array( array(
                                                            'class' =>  'icon-16-menumgr',
                                                            'link' => '/',
                                                            'title' =>'Menu Manager',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-menus-menus',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Menu',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                            array(
                                                            'class' =>  'icon-16-menu',
                                                            'link' => '/',
                                                            'title' =>'User Menu',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-menus-items-usermenu',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Menu Item',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                             array(
                                                            'class' =>  'icon-16-menu',
                                                            'link' => '/',
                                                            'title' =>'Top Menu',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-menus-items-top',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Top Menu',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                             array(
                                                            'class' =>  'icon-16-menu',
                                                            'link' => '/',
                                                            'title' =>'Main Menu',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-menus-items-usermenu',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Menu Item',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                             array(
                                                            'class' =>  'icon-16-menu',
                                                            'link' => '/',
                                                            'title' =>'Test',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-menus-items-test',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Menu Item',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                             ), 
                             'Messaging'=>  array( array(
                                                            'class' =>  'icon-16-messages-add',
                                                            'link' => '/',
                                                            'title' =>'New Private Messages',
                                             ),
                                        array(
                                                            'class' =>  'icon-16-messages-read',
                                                            'link' => '/',
                                                            'title' =>'Read Private Messages',
                                            ),
                             ),
                             'Banners'=>  array( array(
                                                            'class' =>  'icon-16-banners',
                                                            'link' => '/',
                                                            'title' =>'Banners',
                                             ),
                                        array(
                                                            'class' =>  'icon-16-banners-cat',
                                                            'link' => '/',
                                                            'title' =>'Categories',
                                            ),
                                         array(
                                                                    'class' =>  'icon-16-banners-clients',
                                                                    'link' => '/',
                                                                    'title' =>'Clients',
                                              ),
                                         array(
                                                                    'class' =>  'icon-16-banners-tracks',
                                                                    'link' => '/',
                                                                    'title' =>'Tracks',
                                              ),

                                 ), 
                                 'Products'=>  array( array(
                                                            'class' =>  'icon-16-banners',
                                                            'link' => '/',
                                                            'title' =>'Products',
                                             ),
                                 ),
                                 'Content'=>  array( array(
                                                            'class' =>  'icon-16-article',
                                                            'link' => '/',
                                                            'title' =>'Article Manager',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-content',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Article',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ), 
                                            array(
                                                            'class' =>  'icon-16-category',
                                                            'link' => '/',
                                                            'title' =>'Category Manager',
                                                            'node' => array(
                                                                'class' =>  'menu-component',
                                                                'id' => 'menu-com-categories-com-content',                                                              
                                                                'menuChildren' => array( array(
                                                                                                'class' =>  'icon-16-newarticle',                                                                                              
                                                                                                'link' => '/',
                                                                                                'title' =>'Add New Category',
                                                                                                ),
                                                                                                
                                                                                    ),
                                                                ),
                                            ),
                                            array(
                                                                    'class' =>  'icon-16-featured',
                                                                    'link' => '/',
                                                                    'title' =>'Featured Articles',
                                              ),
                                             array(
                                                                    'class' =>  'icon-16-media',
                                                                    'link' => '/',
                                                                    'title' =>'Media Manager',
                                              ),
                                     ),
                                     'Modules'=>  array( array(
                                                            'class' =>  'icon-16-help',
                                                            'link' => '/',
                                                            'title' =>'Manage Modules',
                                             ),
                                     ),
              
                                   'Help'=>  array( array(
                                                            'class' =>  'icon-16-module',
                                                            'link' => '/',
                                                            'title' =>'Infosyspro Help',
                                             ),
                                     ),
          ); 
          
         ob_start();
      echo '<ul id="menu" >' . PHP_EOL;
     
          foreach  ($menuNodes as $node => $menus ) : ?>
              <li class="node"><a href="#"><?php echo $node ?></a><ul>
              
           <?php   
            
            foreach ($menus as $menu ) : 
              
            if(isset($menu['node'])) :  ?>
                    
               <li class="node"><a class="<?php echo $menu['class'] ?>" href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a>
               <ul id="<?php echo $menu['node']['id'] ?>" class="<?php echo $menu['node']['class'] ?>">
                   
               <?php foreach ( $menu['node']['menuChildren'] as $child) : ?>
                    <li><a class="<?php echo $child['class'] ?>" href="<?php echo $child['link'] ?>"><?php echo $child['title'] ?></a></li>
                    <li class="separator"><span></span></li>
                   
              <?php  endforeach; ?>
               </ul>
     
          <?php  else : ?>              
           
               <li><a class="<?php echo $menu['class'] ?>" href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a></li>
               <li class="separator"><span></span></li>
         <?php
          endif;
          endforeach; ?>
          
               </ul>
         </li>
         <?php
          endforeach;
          ?>
           
        </ul>
       <?php
        $contents = ob_get_contents();
        ob_end_clean();
        
        return $contents;
      }
      
     
 }

 