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

 namespace Cms\View\Helper;

 use Zend\View\Helper\AbstractHelper;
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
 class cpanelHtml extends AbstractHelper
 {
     protected $string = '';
     
     public function __construct() 
     {
         $this->string = '<b>test test </b>';
     }
   
     public function leftCpanel($options = null) 
     {
         $icons = array(
             'addNewArticle' => array('link' => '/',
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
      
      public function mainMenu($options)
      {
          ob_start();
          ?>
          
        <ul id="menu" >
            <li class="node"><a href="#">Site</a><ul>
                    <li><a class="icon-16-cpanel" href="index.php">Control Panel</a></li>
                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-profile" href="index.php?option=com_admin&amp;task=profile.edit&amp;id=42">My Profile</a></li>
                    <li class="separator"><span></span></li>

                    <li><a class="icon-16-config" href="index.php?option=com_config">Global Configuration</a></li>
                    <li class="separator"><span></span></li>
                    <li class="node"><a class="icon-16-maintenance" href="index.php?option=com_checkin">Maintenance</a><ul id="menu-com-checkin" class="menu-component">
                            <li><a class="icon-16-checkin" href="index.php?option=com_checkin">Global Check-in</a></li>
                            <li class="separator"><span></span></li>
                            <li><a class="icon-16-clear" href="index.php?option=com_cache">Clear Cache</a></li>
                            <li><a class="icon-16-purge" href="index.php?option=com_cache&amp;view=purge">Purge Expired Cache</a></li>
                        </ul>
                    </li>
                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-info" href="index.php?option=com_admin&amp;view=sysinfo">System Information</a></li>

                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-logout" href="/administrator/index.php?option=com_login&amp;task=logout&amp;112d562223da4b0a0cfa3ad844bda34a=1">Logout</a></li>
                </ul>
            </li>
            <li class="node"><a href="#">Users</a><ul>
                    <li class="node"><a class="icon-16-user" href="index.php?option=com_users&amp;view=users">User Manager</a><ul id="menu-com-users-users" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_users&amp;task=user.add">Add New User</a></li>
                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-groups" href="index.php?option=com_users&amp;view=groups">Groups</a><ul id="menu-com-users-groups" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_users&amp;task=group.add">Add New Group</a></li>

                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-levels" href="index.php?option=com_users&amp;view=levels">Access Levels</a><ul id="menu-com-users-levels" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_users&amp;task=level.add">Add New Access Level</a></li>
                        </ul>
                    </li>
                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-massmail" href="index.php?option=com_users&amp;view=mail">Mass Mail Users</a></li>
                </ul>
            </li>
            <li class="node"><a href="#">Menus</a><ul>
                    <li class="node"><a class="icon-16-menumgr" href="index.php?option=com_menus&amp;view=menus">Menu Manager</a><ul id="menu-com-menus-menus" class="menu-component">

                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=menu&amp;layout=edit">Add New Menu</a></li>
                        </ul>
                    </li>
                    <li class="separator"><span></span></li>
                    <li class="node"><a class="icon-16-menu" href="index.php?option=com_menus&amp;view=items&amp;menutype=usermenu">User Menu</a><ul id="menu-com-menus-items-usermenu" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;menutype=usermenu">Add New Menu Item</a></li>
                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-menu" href="index.php?option=com_menus&amp;view=items&amp;menutype=top">Top</a><ul id="menu-com-menus-items-top" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;menutype=top">Add New Menu Item</a></li>
                        </ul>
                    </li>

                    <li class="node"><a class="icon-16-menu" href="index.php?option=com_menus&amp;view=items&amp;menutype=aboutjoomla">About Joomla</a><ul id="menu-com-menus-items-aboutjoomla" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;menutype=aboutjoomla">Add New Menu Item</a></li>
                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-menu" href="index.php?option=com_menus&amp;view=items&amp;menutype=parks">Australian Parks</a><ul id="menu-com-menus-items-parks" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;menutype=parks">Add New Menu Item</a></li>
                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-menu" href="index.php?option=com_menus&amp;view=items&amp;menutype=mainmenu">Main Menu <span><img src="/administrator/templates/bluestork/images/menu/icon-16-default.png" alt="*" title="Home" /></span></a><ul id="menu-com-menus-items-mainmenu" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;menutype=mainmenu">Add New Menu Item</a></li>
                        </ul>

                    </li>
                    <li class="node"><a class="icon-16-menu" href="index.php?option=com_menus&amp;view=items&amp;menutype=fruitshop">Fruit Shop</a><ul id="menu-com-menus-items-fruitshop" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_menus&amp;view=item&amp;layout=edit&amp;menutype=fruitshop">Add New Menu Item</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="node"><a href="#">Content</a><ul>
                    <li class="node"><a class="icon-16-article" href="index.php?option=com_content">Article Manager</a><ul id="menu-com-content" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_content&amp;task=article.add">Add New Article</a></li>
                        </ul>
                    </li>

                    <li class="node"><a class="icon-16-category" href="index.php?option=com_categories&amp;extension=com_content">Category Manager</a><ul id="menu-com-categories-com-content" class="menu-component">
                            <li><a class="icon-16-newarticle" href="index.php?option=com_categories&amp;task=category.add&amp;extension=com_content">Add New Category</a></li>
                        </ul>
                    </li>
                    <li><a class="icon-16-featured" href="index.php?option=com_content&amp;view=featured">Featured Articles</a></li>
                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-media" href="index.php?option=com_media">Media Manager</a></li>
                </ul>
            </li>
            <li class="node"><a href="#">Components</a><ul>
                    <li class="node"><a class="icon-16-banners" href="index.php?option=com_banners">Banners</a><ul id="menu-com-banners" class="menu-component">

                            <li><a class="icon-16-banners" href="index.php?option=com_banners">Banners</a></li>
                            <li><a class="icon-16-banners-cat" href="index.php?option=com_categories&amp;extension=com_banners">Categories</a></li>
                            <li><a class="icon-16-banners-clients" href="index.php?option=com_banners&amp;view=clients">Clients</a></li>
                            <li><a class="icon-16-banners-tracks" href="index.php?option=com_banners&amp;view=tracks">Tracks</a></li>
                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-contact" href="index.php?option=com_contact">Contacts</a><ul id="menu-com-contact" class="menu-component">
                            <li><a class="icon-16-contact" href="index.php?option=com_contact">Contacts</a></li>
                            <li><a class="icon-16-contact-cat" href="index.php?option=com_categories&amp;extension=com_contact">Categories</a></li>
                        </ul>

                    </li>
                    <li class="node"><a class="icon-16-messages" href="index.php?option=com_messages">Messaging</a><ul id="menu-com-messages" class="menu-component">
                            <li><a class="icon-16-messages-add" href="index.php?option=com_messages&amp;task=message.add">New Private Message</a></li>
                            <li><a class="icon-16-messages-read" href="index.php?option=com_messages">Read Private Messages</a></li>
                        </ul>
                    </li>
                    <li class="node"><a class="icon-16-newsfeeds" href="index.php?option=com_newsfeeds">Newsfeeds</a><ul id="menu-com-newsfeeds" class="menu-component">
                            <li><a class="icon-16-newsfeeds" href="index.php?option=com_newsfeeds">Feeds</a></li>
                            <li><a class="icon-16-newsfeeds-cat" href="index.php?option=com_categories&amp;extension=com_newsfeeds">Categories</a></li>
                        </ul>
                    </li>

                    <li><a class="icon-16-redirect" href="index.php?option=com_redirect">Redirect</a></li>
                    <li><a class="icon-16-search" href="index.php?option=com_search">Search</a></li>
                    <li class="node"><a class="icon-16-weblinks" href="index.php?option=com_weblinks">Weblinks</a><ul id="menu-com-weblinks" class="menu-component">
                            <li><a class="icon-16-weblinks" href="index.php?option=com_weblinks">Links</a></li>
                            <li><a class="icon-16-weblinks-cat" href="index.php?option=com_categories&amp;extension=com_weblinks">Categories</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="node"><a href="#">Extensions</a><ul>
                    <li><a class="icon-16-install" href="index.php?option=com_installer">Extension Manager</a></li>

                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-module" href="index.php?option=com_modules">Module Manager</a></li>
                    <li><a class="icon-16-plugin" href="index.php?option=com_plugins">Plug-in Manager</a></li>
                    <li><a class="icon-16-themes" href="index.php?option=com_templates">Template Manager</a></li>
                    <li><a class="icon-16-language" href="index.php?option=com_languages">Language Manager</a></li>
                </ul>
            </li>
            <li class="node"><a href="#">Help</a><ul>
                    <li><a class="icon-16-help" href="index.php?option=com_admin&amp;view=help">Joomla Help</a></li>
                    <li class="separator"><span></span></li>
                    <li><a class="icon-16-help-forum" href="http://forum.joomla.org" target="_blank" >Official Support Forum</a></li>

                    <li><a class="icon-16-help-docs" href="http://docs.joomla.org" target="_blank" >Documentation Wiki</a></li>
                    <li class="separator"><span></span></li>
                    <li class="node"><a class="icon-16-weblinks" href="#">Useful Joomla links</a><ul class="menu-component">
                            <li><a class="icon-16-help-jed" href="http://extensions.joomla.org" target="_blank" >Joomla Extensions</a></li>
                            <li><a class="icon-16-help-trans" href="http://community.joomla.org/translations.html" target="_blank" >Joomla Translations</a></li>
                            <li><a class="icon-16-help-jrd" href="http://resources.joomla.org" target="_blank" >Joomla Resources</a></li>
                            <li><a class="icon-16-help-community" href="http://community.joomla.org" target="_blank" >Community Portal</a></li>
                            <li><a class="icon-16-help-security" href="http://developer.joomla.org/security.html" target="_blank" >Security Center</a></li>
                            <li><a class="icon-16-help-dev" href="http://developer.joomla.org" target="_blank" >Developer Resources</a></li>

                            <li><a class="icon-16-help-shop" href="http://shop.joomla.org" target="_blank" >Joomla Shop</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
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
    
    protected function render(){
        return $this->string;
    }
 }

 