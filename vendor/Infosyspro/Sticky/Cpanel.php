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
 class Cpanel extends AbstractSticky
 {
     protected $string = '';
     
   public function leftCpanel($options = null) 
     {
         $icons = array(
             'addNewArticle' => array('link' => '/cms/create',
                                       'icon' => '/media/cms/images/header/icon-48-article-add.png',
                                       'title' => 'Add New Article',
                                    ),
             'articleManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-article.png',
                                       'title' => 'Article Manager',
                                    ),
              'categoryManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-category.png',
                                       'title' => 'Category Manager',
                                    ),
             'mediaManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-media.png',
                                       'title' => 'Media Manager',
                                    ),
             'menuManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-menumgr.png',
                                       'title' => 'Menu Manager',
                                    ),
             'userManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-user.png',
                                       'title' => 'User Manager',
                                    ),
             'moduleManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-module.png',
                                       'title' => 'Module Manager',
                                    ),
             'extensionManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-language.png',
                                       'title' => 'Extension Manager',
                                    ),
             'languageManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-language.png',
                                       'title' => 'Language Manager',
                                    ),
             'globalConfiguration' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-config.png',
                                       'title' => 'Global Configuration',
                                    ),
             'templateManager' => array('link' => '/',
                                       'icon' => '/media/cms/images/header/icon-48-themes.png',
                                       'title' => 'Template Manager',
                                    ),
         );
         
         ob_start();
         ?>        
         <div id="cpanel">
         <?php  
           foreach ($icons as $title =>$icon) : ?>
 
                 <div class="icon-wrapper">
                     <div class="icon">
                        <a href="<?php echo $icon['link'] ?>">
                        <img src="<?php echo $icon['icon'] ?>" alt="<?php echo $icon['title']?>"  />			
                        <span><?php echo $icon['title'] ?></span></a>
                      </div>
                  </div>                     
        <?php endforeach; ?>
             
         </div>
       
        <?php
        $contents = ob_get_contents();
        ob_end_clean();
        
        return $contents;
     }
   
     public function rightCpanel($options = null) 
     {
         ob_start();
         ?>
                     <div id="panel-sliders" class="pane-sliders">
                        <div style="display:none;"><div></div></div>
                        <div class="panel"><h3 class="pane-toggler title" id="cpanel-panel-logged"><a href="javascript:void(0);">
                                    <span>Last 5 Logged-in Users</span></a></h3>
                            <div class="pane-slider content"><table class="adminlist">

                                    <thead>
                                        <tr>
                                            <th>
                                                Name			</th>
                                            <th>
                                                <strong>Location</strong>
                                            </th>
                                            <th>

                                                <strong>ID</strong>
                                            </th>
                                            <th>
                                                <strong>Last Activity</strong>
                                            </th>
                                            <th>
                                                <strong>Logout</strong>

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                <a href="/administrator/index.php?option=com_users&amp;task=user.edit&amp;id=42">
                                                    Super User</a>

                                            </th>
                                            <td class="center">
                                                Administrator			</td>
                                            <td class="center">
                                                42			</td>
                                            <td class="center">
                                                2011-11-19 07:37:00			</td>

                                            <td class="center">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div></div><div class="panel"><h3 class="pane-toggler title" id="cpanel-panel-popular"><a href="javascript:void(0);"><span>Top 5 Popular Articles</span></a></h3><div class="pane-slider content"><table class="adminlist">
                                    <thead>
                                        <tr>
                                            <th>

                                                Popular Items			</th>
                                            <th>
                                                <strong>Created</strong>
                                            </th>
                                            <th>
                                                <strong>Hits				</strong>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=55">
                                                    Weblinks Module</a>
                                            </th>

                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                23			</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=21">

                                                    Getting Help</a>
                                            </th>
                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                17			</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=27">
                                                    Latest Articles Module</a>
                                            </th>
                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">

                                                15			</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=59">
                                                    Wrapper Module</a>
                                            </th>
                                            <td class="center">

                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                15			</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=12">
                                                    Custom HTML Module</a>

                                            </th>
                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                13			</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div></div><div class="panel"><h3 class="pane-toggler title" id="cpanel-panel-latest"><a href="javascript:void(0);"><span>Last 5 Added Articles</span></a></h3><div class="pane-slider content"><table class="adminlist">
                                    <thead>
                                        <tr>
                                            <th>
                                                Latest Items			</th>
                                            <th>
                                                <strong>Status</strong>
                                            </th>

                                            <th>
                                                <strong>Created</strong>
                                            </th>
                                            <th>
                                                <strong>Created By</strong>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=66">
                                                    Latest Users Module</a>
                                            </th>
                                            <td class="center">
                                                <a class="jgrid" title="Published"><span class="state publish"><span class="text">Published</span></span></a>			</td>

                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                Super User			</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=21">

                                                    Getting Help</a>
                                            </th>
                                            <td class="center">
                                                <a class="jgrid" title="Published"><span class="state publish"><span class="text">Published</span></span></a>			</td>
                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">

                                                Super User			</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=43">
                                                    Spotted Quoll</a>
                                            </th>
                                            <td class="center">

                                                <a class="jgrid" title="Published"><span class="state publish"><span class="text">Published</span></span></a>			</td>
                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                Super User			</td>
                                        </tr>
                                        <tr>

                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=10">
                                                    Content</a>
                                            </th>
                                            <td class="center">
                                                <a class="jgrid" title="Published"><span class="state publish"><span class="text">Published</span></span></a>			</td>
                                            <td class="center">

                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                Super User			</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">

                                                <a href="/administrator/index.php?option=com_content&amp;task=article.edit&amp;id=32">
                                                    Parameters</a>

                                            </th>
                                            <td class="center">
                                                <a class="jgrid" title="Published"><span class="state publish"><span class="text">Published</span></span></a>			</td>
                                            <td class="center">
                                                2011-01-01 00:00:01			</td>
                                            <td class="center">
                                                Super User			</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div></div></div>
               

         <?php
           $contents = ob_get_contents();
        ob_end_clean();
        
        return $contents;
        
      }
      
     

      /**
     * Serialize as string
     *
     * Proxies to {@link render()}.
     *
     * @return string
     */
    public function __toString()
    {        
        return $this->render();
    }
    
   
 }

 