DROP TABLE IF EXISTS `TbACCS_BALANCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbACCS_BALANCE` (
  `ACCNO` int(20) NOT NULL AUTO_INCREMENT,
  `ALPHACODE` varchar(15) DEFAULT NULL,
  `NAME` varchar(40) DEFAULT NULL,
  `ACCGROUP` int(11) DEFAULT NULL,
  `CURRENCYNO` int(11) DEFAULT NULL,
  `HEAD_ACCNO` int(11) DEFAULT NULL,
  `ISHEADOFFICE` char(1) DEFAULT 'N',
  `AGEDBAL0` float DEFAULT NULL,
  `AGEDBAL1` float DEFAULT NULL,
  `AGEDBAL2` float DEFAULT NULL,
  `AGEDBAL3` float DEFAULT NULL,
  `BALANCE` float DEFAULT NULL,
  `PRIOR_AGEDBAL0` float DEFAULT NULL,
  `PRIOR_AGEDBAL1` float DEFAULT NULL,
  `PRIOR_AGEDBAL2` float DEFAULT NULL,
  `PRIOR_AGEDBAL3` float DEFAULT NULL,
  `PRIOR_BALANCE` float DEFAULT NULL,
  `POST_CODE` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`ACCNO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbAclResources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbAclResources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `inheritsFrom_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbAclResources` VALUES (1,'cms',NULL,0),(2,'home',NULL,0),(3,'site',1,1),(4,'template',1,2),(5,'user',1,3),(6,'blog',1,4),(7,'articles',1,5),(8,'lite',1,6),(9,'standard',8,2),(10,'premium',9,3);
DROP TABLE IF EXISTS `TbAclRoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbAclRoles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `inheritsFrom_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbAclRoles` VALUES (1,'guest',0,1,'Public Access'),(2,'registered',1,2,'Registered Users'),(3,'editor',2,3,'Content Editor'),(4,'publisher',3,4,'Content Publisher'),(5,'manager',3,4,'Content Manager'),(6,'administrator',0,999,'Super Administrator');
DROP TABLE IF EXISTS `TbAclRolesResources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbAclRolesResources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_role_id` int(10) unsigned NOT NULL,
  `acl_resource_id` int(10) unsigned NOT NULL,
  `privilege` varchar(45) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_role_res_priv` (`acl_role_id`,`acl_resource_id`,`privilege`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbAclRolesResources` VALUES (1,1,2,'edit',0),(2,2,1,'view',2);
DROP TABLE IF EXISTS `TbBanners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbBanners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbBanners` VALUES (2,3,0,'Shop 1','shop-1',0,62,2,'http://shop.joomla.org/amazoncom-bookstores.html',1,15,'Get books about Joomla! at the Joomla! book shop.','',0,1,'','{\"imageurl\":\"images\\/banners\\/white.png\",\"width\":\"\",\"height\":\"\",\"alt\":\"Joomla! Books\"}',0,'',-1,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2011-01-01 00:00:01','en-GB'),(3,2,0,'Shop 2','shop-2',0,112,2,'http://shop.joomla.org',1,15,'T Shirts, caps and more from the Joomla! Shop.','',0,2,'','{\"imageurl\":\"images\\/banners\\/white.png\",\"width\":\"\",\"height\":\"\",\"alt\":\"Joomla! Shop\"}',0,'',-1,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2011-01-01 00:00:01','en-GB'),(4,1,0,'Support Joomla!','support-joomla',0,31,1,'http://contribute.joomla.org',1,15,'Your contributions of time, talent and money make Joomla! possible.','',0,3,'','{\"imageurl\":\"images\\/banners\\/white.png\",\"width\":\"\",\"height\":\"\",\"alt\":\"\"}',0,'',-1,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','en-GB');
DROP TABLE IF EXISTS `TbBlocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbBlocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) DEFAULT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `numnews` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `contentOrder` int(1) NOT NULL DEFAULT '0' COMMENT 'should we echo module first or content',
  `control` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbBlocks` VALUES (1,'Main Menu','',1,'left',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,1,'{\r\n \"classmod\" : \"test\"\r\n}\r\n',1,0,''),(2,'Login','Login form',1,'login',0,'0000-00-00 00:00:00',0,'mod_login',0,0,1,'',1,1,''),(3,'Popular','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,2,1,'',0,1,''),(4,'Recent added Articles','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,2,1,'ordering=c_dsc\nuser_id=0\ncache=0\n\n',0,1,''),(5,'Menu Stats','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_stats',0,2,1,'',0,1,''),(6,'Unread Messages','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,2,1,'',1,1,''),(7,'Online Users','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,2,1,'',1,1,''),(8,'Toolbar','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,2,1,'',1,1,''),(9,'Quick Icons','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,2,1,'',1,1,''),(10,'Logged in Users','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_logged',0,2,1,'',0,1,''),(11,'Footer','',0,'footer',0,'0000-00-00 00:00:00',1,'mod_footer',0,0,1,'',1,1,''),(12,'Admin Menu','',1,'menu',0,'0000-00-00 00:00:00',1,'mod_menu',0,2,1,'',0,1,''),(13,'Admin SubMenu','',1,'submenu',0,'0000-00-00 00:00:00',1,'mod_submenu',0,2,1,'',0,1,''),(14,'User Status','',1,'status',0,'0000-00-00 00:00:00',1,'mod_status',0,2,1,'',0,1,''),(15,'Title','',1,'title',0,'0000-00-00 00:00:00',1,'mod_title',0,2,1,'',0,1,''),(16,'Polls','',6,'right',0,'0000-00-00 00:00:00',1,'mod_poll',0,0,1,'id=14\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n',0,0,''),(17,'User Menu','',9,'left',1,'0000-00-00 00:00:00',0,'mod_mainmenu',0,1,1,'menutype=usermenu\nmoduleclass_sfx=_menu\ncache=1',1,0,''),(18,'Login Form','<div id=\"login-module\">\r\n<div>\r\n<form id=\"login\" name=\"login\" method=\"post\" action=\"http://www.sugarfreepeople.com/index.php?option=com_user&task=login\">\r\n<div class=\"username-block\">\r\n<label for=\"username_vmlogin\">Username</label>\r\n<input id=\"username_vmlogin\" class=\"inputbox\" type=\"text\" name=\"username\" size=\"12\">\r\n</div><br />\r\n<div class=\"password-block\">\r\n<label for=\"password_vmlogin\">Password</label>\r\n<input id=\"password_vmlogin\" class=\"inputbox\" type=\"password\" name=\"passwd\" size=\"12\">\r\n</div>\r\n<div class=\"login-extras\">\r\n<label for=\"remember_vmlogin\">Remember me</label>\r\n<input id=\"remember_vmlogin\" type=\"checkbox\" checked=\"checked\" value=\"yes\" name=\"remember\">\r\n<input class=\"button\" type=\"submit\" name=\"Login\" value=\"Login\">\r\n<ul>\r\n<li>\r\n<a href=\"/index.php?option=com_user&view=reset\">Lost Password?</a>\r\n</li>\r\n<li>\r\n<a href=\"/index.php?option=com_user&view=remind\">Forgot your username?</a>\r\n</li>\r\n</ul>\r\n<input type=\"hidden\" name=\"op2\" value=\"login\">\r\n<input type=\"hidden\" name=\"return\" value=\"aHR0cDovL3N1Z2FyZnJlZS5pbmZvc3lzcHJvLmNvbS9pbmRleC5waHA/b3B0aW9uPWNvbV9jb250ZW50JnZpZXc9YXJ0aWNsZSZpZD01MiZJdGVtaWQ9NjY=\">\r\n<input type=\"hidden\" value=\"1\" name=\"38a31ed5af6e9982a2ef2d9124570fe1\">\r\n</div>\r\n</form>\r\n</div>\r\n</div>\r\n',2,'right',0,'0000-00-00 00:00:00',1,'mod_login',0,0,1,'{\r\n\"moduleclass_sfx\" : \"bettey\" \r\n}\r\n\r\n\r\n',1,0,''),(19,'Latest News','',0,'user4',0,'0000-00-00 00:00:00',1,'mod_latestnews',0,0,1,'count=5\nordering=c_dsc\nuser_id=0\nshow_front=1\nsecid=\ncatid=\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n',1,0,''),(20,'Products Categories','Firstly we tell the Di object that the setDatabaseAdapter() method is required in order to instantiate My\\UserTable objects and then our usual call to get will work. It therefore follows that if your object has more than one set method that you want to be called by Di, then you set the required flag on all of them within the Configuration object.',11,'left',0,'0000-00-00 00:00:00',1,'mod_stats',0,0,1,'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=',0,0,''),(21,'Who\'s Online','',21,'left',0,'0000-00-00 00:00:00',0,'mod_whosonline',0,0,1,'cache=0\nshowmode=0\nmoduleclass_sfx=\n\n',0,0,''),(22,'Popular','',0,'user5',0,'0000-00-00 00:00:00',1,'mod_mostread',0,0,1,'moduleclass_sfx=\nshow_front=1\ncount=5\ncatid=\nsecid=\ncache=1\ncache_time=900\n\n',0,0,''),(23,'Archive','',12,'left',0,'0000-00-00 00:00:00',0,'mod_archive',0,0,1,'cache=1',1,0,''),(24,'Sections','',13,'left',0,'0000-00-00 00:00:00',0,'mod_sections',0,0,1,'cache=1',1,0,''),(25,'Newsflash','',6,'user1',0,'0000-00-00 00:00:00',0,'mod_newsflash',0,0,1,'catid=3\nlayout=default\nimage=0\nlink_titles=\nshowLastSeparator=1\nreadmore=0\nitem_title=0\nitems=\nmoduleclass_sfx=\ncache=0\ncache_time=900\n\n',0,0,''),(26,'Related Items','',14,'left',0,'0000-00-00 00:00:00',0,'mod_related_items',0,0,1,'',0,0,''),(27,'Search','',1,'search-right',0,'0000-00-00 00:00:00',0,'mod_search',0,0,0,'moduleclass_sfx=\nwidth=20\ntext=\nbutton=\nbutton_pos=right\nimagebutton=\nbutton_text=\ncache=1\ncache_time=900\n\n',0,0,''),(28,'Random Image','This is another test',12,'right',0,'0000-00-00 00:00:00',1,'mod_random_image',0,0,1,'',0,0,''),(29,'Top Menu','',1,'bottom-menu',0,'0000-00-00 00:00:00',1,'mod_mainmenu',0,0,0,'menutype=topmenu\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=-nav\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=-1\nindent_image2=-1\nindent_image3=-1\nindent_image4=-1\nindent_image5=-1\nindent_image6=-1\nspacer=\nend_spacer=\n\n',1,0,''),(30,'Banners','',4,'user1',0,'0000-00-00 00:00:00',0,'mod_banners',0,0,0,'target=1\ncount=1\ncid=1\ncatid=33\ntag_search=0\nordering=random\nheader_text=\nfooter_text=\nmoduleclass_sfx=\ncache=1\ncache_time=15\n\n',1,0,''),(31,'Resources','',7,'left',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,1,'menutype=othermenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n',0,0,''),(32,'Wrapper','',15,'left',0,'0000-00-00 00:00:00',0,'mod_wrapper',0,0,1,'',0,0,''),(33,'Footer','',1,'footer',0,'0000-00-00 00:00:00',1,'mod_footer',0,0,0,'cache=1\n\n',1,0,''),(34,'Feed Display','',16,'left',0,'0000-00-00 00:00:00',0,'mod_feed',0,0,1,'',1,0,''),(35,'Breadcrumbs','',0,'breadcrumb',0,'0000-00-00 00:00:00',1,'mod_breadcrumbs',0,0,1,'showHome=1\nhomeText=Home\nshowLast=1\nseparator=/\nmoduleclass_sfx=\ncache=0\n\n',1,0,''),(36,'Syndication','',1,'syndicate',0,'0000-00-00 00:00:00',1,'mod_syndicate',0,0,0,'',1,0,''),(38,'Advertisement','',7,'right',0,'0000-00-00 00:00:00',1,'mod_banners',0,0,1,'target=1\ncount=4\ncid=0\ncatid=14\ntag_search=0\nordering=0\nheader_text=Featured Links:\nfooter_text=<a href=\"http://www.joomla.org\">Ads by Joomla!</a>\nmoduleclass_sfx=_text\ncache=0\ncache_time=900\n\n',0,0,''),(39,'Example Pages','',10,'left',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,1,'cache=1\nclass_sfx=\nmoduleclass_sfx=_menu\nmenutype=ExamplePages\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nfull_active_id=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nactivate_parent=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\nwindow_open=\n\n',0,0,''),(40,'Key Concepts','',8,'left',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,1,'menutype=keyconcepts\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n',0,0,''),(41,'Welcome to Joomla!','<div style=\"padding: 5px\">  <p>   Congratulations on choosing Joomla! as your content management system. To   help you get started, check out these excellent resources for securing your   server and pointers to documentation and other helpful resources. </p> <p>   <strong>Security</strong><br /> </p> <p>   On the Internet, security is always a concern. For that reason, you are   encouraged to subscribe to the   <a href=\"http://feedburner.google.com/fb/a/mailverify?uri=JoomlaSecurityNews\" target=\"_blank\">Joomla!   Security Announcements</a> for the latest information on new Joomla! releases,   emailed to you automatically. </p> <p>   If this is one of your first Web sites, security considerations may   seem complicated and intimidating. There are three simple steps that go a long   way towards securing a Web site: (1) regular backups; (2) prompt updates to the   <a href=\"http://www.joomla.org/download.html\" target=\"_blank\">latest Joomla! release;</a> and (3) a <a href=\"http://docs.joomla.org/Security_Checklist_2_-_Hosting_and_Server_Setup\" target=\"_blank\" title=\"good Web host\">good Web host</a>. There are many other important security considerations that you can learn about by reading the <a href=\"http://docs.joomla.org/Category:Security_Checklist\" target=\"_blank\" title=\"Joomla! Security Checklist\">Joomla! Security Checklist</a>. </p> <p>If you believe your Web site was attacked, or you think you have discovered a security issue in Joomla!, please do not post it in the Joomla! forums. Publishing this information could put other Web sites at risk. Instead, report possible security vulnerabilities to the <a href=\"http://developer.joomla.org/security/contact-the-team.html\" target=\"_blank\" title=\"Joomla! Security Task Force\">Joomla! Security Task Force</a>.</p><p><strong>Learning Joomla!</strong> </p> <p>   A good place to start learning Joomla! is the   \"<a href=\"http://docs.joomla.org/beginners\" target=\"_blank\">Absolute Beginner\'s   Guide to Joomla!.</a>\" There, you will find a Quick Start to Joomla!   <a href=\"http://help.joomla.org/ghop/feb2008/task048/joomla_15_quickstart.pdf\" target=\"_blank\">guide</a>   and <a href=\"http://help.joomla.org/ghop/feb2008/task167/index.html\" target=\"_blank\">video</a>,   amongst many other tutorials. The   <a href=\"http://community.joomla.org/magazine/view-all-issues.html\" target=\"_blank\">Joomla!   Community Magazine</a> also has   <a href=\"http://community.joomla.org/magazine/article/522-introductory-learning-joomla-using-sample-data.html\" target=\"_blank\">articles   for new learners</a> and experienced users, alike. A great place to look for   answers is the   <a href=\"http://docs.joomla.org/Category:FAQ\" target=\"_blank\">Frequently Asked   Questions (FAQ)</a>. If you are stuck on a particular screen in the   Administrator (which is where you are now), try clicking the Help toolbar   button to get assistance specific to that page. </p> <p>   If you still have questions, please feel free to use the   <a href=\"http://forum.joomla.org/\" target=\"_blank\">Joomla! Forums.</a> The forums   are an incredibly valuable resource for all levels of Joomla! users. Before   you post a question, though, use the forum search (located at the top of each   forum page) to see if the question has been asked and answered. </p> <p>   <strong>Getting Involved</strong> </p> <p>   <a name=\"twjs\" title=\"twjs\"></a> If you want to help make Joomla! better, consider getting   involved. There are   <a href=\"http://www.joomla.org/about-joomla/contribute-to-joomla.html\" target=\"_blank\">many ways   you can make a positive difference.</a> Have fun using Joomla!.</p></div>',0,'cpanel',0,'0000-00-00 00:00:00',1,'mod_custom',0,2,1,'moduleclass_sfx=\n\n',1,1,''),(42,'Joomla! Security Newsfeed','',6,'cpanel',0,'0000-00-00 00:00:00',1,'mod_feed',0,0,1,'cache=1\ncache_time=15\nmoduleclass_sfx=\nrssurl=http://feeds.joomla.org/JoomlaSecurityNews\nrssrtl=0\nrsstitle=1\nrssdesc=0\nrssimage=1\nrssitems=1\nrssitemdesc=1\nword_count=0\n\n',0,1,''),(43,'RokNavMenu','',1,'toolbar',0,'0000-00-00 00:00:00',0,'mod_roknavmenu',0,0,1,'menutype=mainmenu\nlimit_levels=0\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\ntemplate_menuRowsPerColumn=\ntemplate_menuColumns=\ntemplate_menuMultiColLevel=\nurl_type=relative\ncache=0\nmodule_cache=1\ncache_time=900\ntag_id=\nclass_sfx=\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_link=0\n\n',0,0,''),(44,'RokAjaxSearch','',0,'search-left',0,'0000-00-00 00:00:00',1,'mod_rokajaxsearch',0,0,0,'moduleclass_sfx=\nsearch_page=index2.php?option=com_search&view=search&tmpl=component\nadv_search_page=index.php?option=com_search&view=search\ninclude_css=1\nsearchphrase=any\nordering=newest\nlimit=10\nperpage=3\nhide_divs=\ninclude_link=1\nshow_description=1\ninclude_category=1\nshow_readmore=1\n\n',0,0,''),(45,'Product Categories','',17,'left',0,'0000-00-00 00:00:00',1,'mod_rokvirtuemart_categories',0,0,1,'moduleclass_sfx=\n\n',0,0,''),(47,'RokVirtuemart Scroller','',1,'scroller',0,'0000-00-00 00:00:00',1,'mod_rokvirtuemart_scroller',0,0,0,'moduleclass_sfx=\nsorting=random\nfeatured=yes\nshow_title=1\nshow_price=1\ncount=9\ndirection=horizontal\nheight=300\nduration=800\nfxeffect=Quad.easeOut\namount=200\narrows_effect=1\narrows_color=auto\nautoscroll=0\nscrolldelay=2\ncache=0\ncache_time=900\n\n',0,0,''),(48,'Showcase Hero','<div class=\"showcase-hero\"></div>',1,'showcase',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,''),(90,'Mod Showcase2','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.',1,'showcase2',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=media\n\n',0,0,''),(91,'Mod Showcase3','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.',1,'showcase3',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=user\n\n',0,0,''),(92,'Mod Bottom2','This is the <b>Bottom2</b> module position, which is using the <b>cart</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'bottom2',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=cart\n\n',0,0,''),(93,'Mod Bottom3','This is the <b>Bottom3</b> module position, which is using the <b>user</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'bottom3',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=user\n\n',0,0,''),(54,'Currency Selector','',19,'left',0,'0000-00-00 00:00:00',1,'mod_virtuemart_currencies',0,0,1,'text_before=\nproduct_currency=AUD,BRL,CAD,EUR,JPY,USD,\ncache=0\nmoduleclass_sfx=\nclass_sfx=\n\n',0,0,''),(94,'Featured Products','',5,'right',0,'0000-00-00 00:00:00',1,'mod_rokvirtuemart_featureprod',0,0,1,'max_items=2\nshow_price=1\nshow_addtocart=1\ndisplay_style=vertical\nproducts_per_row=4\ncategory_id=\ncache=0\nmoduleclass_sfx=cart\nclass_sfx=\n\n',0,0,''),(95,'More Information','[moreinfo icon=\"1\" url=\"index.php?option=com_content&amp;view=article&amp;id=53&amp;Itemid=68\" title=\"More Information\"]Learn more about Mynxx[/moreinfo]\r\n\r\n[moreinfo icon=\"2\" url=\"index.php?option=com_content&amp;view=article&amp;id=52&amp;Itemid=66\" title=\"The Top Lists\"]Lots of typography to choose from.[/moreinfo]\r\n\r\n[moreinfo icon=\"3\" url=\"index.php?option=com_content&amp;view=article&amp;id=46&amp;Itemid=54\" title=\"More Features\"]New dynamic functionality and options.[/moreinfo]',20,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,''),(62,'Shopping Content','<b>Important:</b> This demo is purely for demonstration purposes and all the content relating to products, services and events are fictional and are designed to showcase a live shopping site. All images are copyrighted to their respective owners.',4,'right',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=\n\n',0,0,''),(63,'Virtuemart','Virtuemart is the most popular shopping component Joomla. For more information on Virtuemart, please go to <a href=\"http://www.virtuemart.net\">www.virtuemart.net</a>',22,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=\n\n',0,0,''),(64,'Mod Left','This is the <b>Left</b> module position, which is using the <b>color1</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',3,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color1\n\n',0,0,''),(65,'Blog Menu','the lazy fox jumped or the sleeping rabbit\r\n[[a]] Lastname [[b]]',8,'right',0,'0000-00-00 00:00:00',1,'BlogMenu',0,0,1,'moduleclass_sfx=color2\n\n',1,1,''),(102,'Mod Right','This is the <b>Right</b> module position, which is using the <b>arrow2</b> module class suffix.',10,'right',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'{\"moduleclass\" : \"arrow2\" }\r\n\r\n',0,0,''),(66,'Mod User1','This is the <b>User1</b> module position, which is using the <b>faq</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',5,'user1',0,'0000-00-00 00:00:00',0,'mod_custom',0,0,1,'moduleclass_sfx=faq\n\n',0,0,''),(67,'Mod User2','This is the <b>User2</b> module position, which is using the <b>cart</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',2,'user2',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=cart\n\n',0,0,''),(68,'Mod User3','This is the <b>User3</b> module position, which is using the <b>rss</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',1,'user3',0,'0000-00-00 00:00:00',0,'mod_custom',0,0,1,'moduleclass_sfx=rss\n\n',0,0,''),(69,'Mod User4','This is the <b>User4</b> module position, which is using the <b>media</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',2,'user4',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=media\n\n',0,0,''),(70,'Mod User5','This is the <b>User5</b> module position, which is using the <b>check</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',2,'user5',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=check\n\n',0,0,''),(71,'Mod User6','This is the <b>User6</b> module position, which is using the <b>info</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'user6',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=info\n\n',0,0,''),(72,'Mod User7','This is the <b>User7</b> module position, which is using the <b>alert</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'user7',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=alert\n\n',0,0,''),(73,'Mod User8','This is the <b>User8</b> module position, which is using the <b>attention</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'user8',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=attention\n\n',0,0,''),(74,'Mod User9','This is the <b>User9</b> module position, which is using the <b>download</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'user9',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=download\n\n',0,0,''),(75,'Mod Inset1','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',2,'inset',62,'2012-01-15 06:13:55',1,'mod_custom',0,0,1,'moduleclass_sfx=\n\n',0,0,''),(76,'Mod Showcase','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.',2,'showcase',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=cart\n\n',0,0,''),(77,'Mod Bottom','This is the <b>Bottom</b> module position, which is using the <b>faq</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'bottom',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=faq\n\n',0,0,''),(78,'Mod Scroller','<b><u>Scroller Module Position</u>: primary function is to accommodate the Virtuemart product scroller.</b><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dapibus, tellus ac ornare aliquam, massa diam tristique urna, id faucibus lectus erat ut pede. Maecenas varius neque nec libero laoreet faucibus. Phasellus sodales, lectus sed vulputate rutrum, ipsum nulla lacinia magna, sed imperdiet ligula nisi eu ipsum.',2,'scroller',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=\n\n',0,0,''),(108,'Testing Information','You can test out the checkout process and view the extensive VirtueMart style customization by using a dummy account information.  Joomla account creation has been turned off in this demo.',18,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color1\n\n',0,0,''),(111,'VirtueMart Login','test form',0,'login',0,'0000-00-00 00:00:00',1,'mod_rokvirtuemart_login',0,0,1,'moduleclass_sfx=\npretext=\nposttext=\nlogin=samepage\nlogout=samepage\ngreeting=1\nname=0\naccountlink=1\n\n',0,0,''),(81,'Mod Left','This is the <b>Left</b> module position, which is using the <b>color2</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',4,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color2\n\n',0,0,''),(100,'Mod Left','This is the <b>Left</b> module position, which is using the <b>arrow</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',6,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=arrow\n\n',0,0,''),(82,'Mod Right','This is the <b>Right</b> module position, which is using the <b>attention</b> module class suffix.',11,'right',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=attention\n\n',0,0,''),(83,'Mod Left','This is the <b>Left</b> module position, which is using the <b>color3</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',5,'left',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color3\n\n',0,0,''),(84,'Mod Right','This is the <b>Right</b> module position, which is using the <b>color3</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',9,'right',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color3\n\n',0,0,''),(85,'Demo Information','<b>Important:</b> This demo is purely for demonstration purposes and all the content relating to products, services and events are fictional and are designed to showcase a live shopping site. All images are copyrighted to their respective owners.  \r\n<br /><br />\r\nThis is not an actual store, non of the products are for sale and the information maybe inaccurate such as pricing.',2,'popup',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=\n\n',0,0,''),(87,'Banner','<img src=\"media/site/images/content/banners/shop-ad-books.jpg\" alt=\"banner\" style=\"margin-left: 43px; display: block; width: 468px;\" />',7,'user1',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,''),(88,'Banner FP','<img src=\"images/banners/shop-ad-books.jpg\" alt=\"banner\" style=\"width: 468px; margin: 0px auto; display: block;\"/>',1,'advertisement',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,''),(89,'RokTabs','',1,'user1',0,'0000-00-00 00:00:00',1,'mod_roktabs',0,0,0,'catid=37\nsecid=1\nordering=m_dsc\nuser_id=0\nstyle=base\nwidth=554\ntabs_count=0\nduration=600\ntransition_type=scrolling\ntransition_fx=Quad.easeInOut\ntabs_position=top\ntabs_title=content\ntabs_incremental=Tab\ntabs_hideh6=1\nautoplay=0\nautoplay_delay=2000\nmoduleclass_sfx=\ncache=0\nmodule_cache=1\ncache_time=900\n\n',0,0,''),(110,'This is user1','You should publish modules to the \"<b>inactive</b>\" position and set the Menus to \"<b>All</b>\", for them to show up on pages where there is no active menu ID.  This is a bug/feature of Joomla that causes only menu items in the \"<b>All</b>\" setting to show up.',0,'user1',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color1\n\n',0,0,''),(101,'Mod Inset2','This is the <b>Inset2</b> module position, which is using the <b>info</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh. Vivamus non arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,'inset2',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=info\n\n',0,0,''),(99,'Mod Right','This is the <b>Right</b> module position, which is using the <b>color1</b> module class suffix.\r\n<br /><br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet nibh.',2,'right',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,1,'moduleclass_sfx=color1\n\n',0,0,''),(107,'Variation Chooser','',1,'right',0,'0000-00-00 00:00:00',1,'mod_variationchooser',0,0,1,'title_length=20\nshow_preview=0\npreview_width=169\npreview_height=189\nmoduleclass_sfx=\n\n',0,0,''),(98,'VM Newsflash','',8,'user1',0,'0000-00-00 00:00:00',1,'mod_newsflash',0,0,0,'catid=38\nlayout=default\nimage=1\nlink_titles=\nshowLastSeparator=1\nreadmore=0\nitem_title=0\nitems=\nmoduleclass_sfx=\ncache=0\ncache_time=900\n\n',0,0,''),(103,'FP Bottom','<div style=\"float: left; width: 22%;\">\r\n\r\n<h3>Popular Accessories</h3>\r\n\r\n<ul>\r\n<li><a href=\"#\">iPhone bluetooth headset</a></li>\r\n<li><a href=\"#\">iPod Touch Battery Pack</a></li>\r\n<li><a href=\"#\">In Car charger</a></li>\r\n<li><a href=\"#\">All terrain laptop case</a></li>\r\n<li><a href=\"#\">Blastout Speakers</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n<div style=\"float: left; width: 22%;\">\r\n\r\n<h3>Latest Products</h3>\r\n\r\n<ul>\r\n<li><a href=\"#\">Macbook Air Rev. 3</a></li>\r\n<li><a href=\"#\">16hr Lithium Battery</a></li>\r\n<li><a href=\"#\">8GB RAM Upgrade kit</a></li>\r\n<li><a href=\"#\">External 190GB SSD</a></li>\r\n<li><a href=\"#\">Chillz Cooler</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n<div style=\"float: left; width: 22%;\">\r\n\r\n<h3>Editors Choice</h3>\r\n\r\n<ul>\r\n<li><a href=\"#\">iPod Touch 16GB</a></li>\r\n<li><a href=\"#\">Macbook Air</a></li>\r\n<li><a href=\"#\">iBlazt Portable Speaker</a></li>\r\n<li><a href=\"#\">TwiceLife Travel Kit</a></li>\r\n<li><a href=\"#\">32GB Upgrade Kit</a></li>\r\n</ul>\r\n\r\n</div>\r\n\r\n\r\n\r\n<div style=\"float: left; width: 33%;\">\r\n\r\n<h3>Disclaimer</h3>\r\n\r\n<strong>Important:</strong> This demo is purely for demonstration purposes and all the content relating to products, services and events are fictional and are designed to showcase a live shopping site. All images are copyrighted to their respective owners. This is not an actual store, only representative of one.\r\n\r\n</div>\r\n\r\n<div class=\"clr\"></div>',2,'bottom',0,'0000-00-00 00:00:00',1,'mod_custom',0,0,0,'moduleclass_sfx=\n\n',0,0,''),(106,'Customer Poll','',23,'left',0,'0000-00-00 00:00:00',1,'mod_poll',0,0,1,'id=15\nmoduleclass_sfx=info\ncache=1\ncache_time=900\n\n',0,0,'');
DROP TABLE IF EXISTS `TbBlocksMenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbBlocksMenu` (
  `blockid` int(11) NOT NULL DEFAULT '0',
  `menuid` varchar(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blockid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbBlocksMenu` VALUES (20,'indexIndex'),(27,'indexindex'),(28,'indexindex'),(65,'blogFirstblogpost'),(65,'blogIndex'),(67,'indexindex'),(75,'indexindexxx'),(83,'indexindex'),(84,'indexindex'),(101,'indexindexxz'),(110,'indexIndex');
DROP TABLE IF EXISTS `TbBlogReplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbBlogReplies` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `blogid` varchar(150) COLLATE utf8_bin NOT NULL,
  `posterEmail` varchar(50) COLLATE utf8_bin NOT NULL,
  `posterName` varchar(50) COLLATE utf8_bin NOT NULL,
  `posterWebsite` varchar(50) COLLATE utf8_bin NOT NULL,
  `posterIp` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `commentApproved` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `commentReported` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `postSubject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` mediumtext COLLATE utf8_bin NOT NULL,
  `commentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_ip` (`posterIp`),
  KEY `post_approved` (`commentApproved`),
  KEY `posterEmail` (`posterEmail`,`posterName`),
  KEY `blogid` (`blogid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbBlogReplies` VALUES (1,'firstblogpost','doabile@infosyspro.com.au','David Oabile','http://www.doabile.com','',1,0,'RE: My First Blog','Testing here','2012-01-29 03:23:49');
DROP TABLE IF EXISTS `TbCONTACTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbCONTACTS` (
  `SEQNO` int(11) NOT NULL,
  `SALUTATION` varchar(4) DEFAULT NULL,
  `FIRSTNAME` varchar(30) DEFAULT NULL,
  `LASTNAME` varchar(30) DEFAULT NULL,
  `TITLE` varchar(30) DEFAULT NULL,
  `MOBILE` varchar(30) DEFAULT NULL,
  `DIRECTPHONE` varchar(30) DEFAULT NULL,
  `DIRECTFAX` varchar(30) DEFAULT NULL,
  `HOMEPHONE` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(60) DEFAULT NULL,
  `NOTES` varchar(4096) DEFAULT NULL,
  `ADDRESS1` varchar(30) DEFAULT NULL,
  `ADDRESS2` varchar(30) DEFAULT NULL,
  `ADDRESS3` varchar(30) DEFAULT NULL,
  `ADDRESS4` varchar(30) DEFAULT NULL,
  `ADDRESS5` varchar(30) DEFAULT NULL,
  `POST_CODE` varchar(12) DEFAULT NULL,
  `DELADDR1` varchar(30) DEFAULT NULL,
  `DELADDR2` varchar(30) DEFAULT NULL,
  `DELADDR3` varchar(30) DEFAULT NULL,
  `DELADDR4` varchar(30) DEFAULT NULL,
  `DELADDR5` varchar(30) DEFAULT NULL,
  `DELADDR6` varchar(30) DEFAULT NULL,
  `ISACTIVE` char(1) DEFAULT 'Y',
  `ADVERTSOURCE` int(11) DEFAULT '0',
  `SALESNO` int(11) DEFAULT '0',
  `FULLNAME` varchar(100) DEFAULT NULL,
  `COMPANY_ACCNO` int(11) DEFAULT NULL,
  `COMPANY_ACCTYPE` int(11) DEFAULT NULL,
  `MSN_ID` varchar(45) DEFAULT NULL,
  `YAHOO_ID` varchar(45) DEFAULT NULL,
  `SKYPE_ID` varchar(45) DEFAULT NULL,
  `LAST_UPDATED` datetime DEFAULT NULL,
  `USERNAME` varchar(30) NOT NULL,
  `PASSWORD` varchar(20) DEFAULT NULL,
  `SUB3` char(1) DEFAULT 'N',
  `SUB4` char(1) DEFAULT 'N',
  `SUB5` char(1) DEFAULT 'N',
  `SUB6` char(1) DEFAULT 'N',
  `SUB7` char(1) DEFAULT 'N',
  `SUB8` char(1) DEFAULT 'N',
  `SUB9` char(1) DEFAULT 'N',
  `SUB10` char(1) DEFAULT 'N',
  `SUB11` char(1) DEFAULT 'N',
  `SUB12` char(1) DEFAULT 'N',
  `SUB13` char(1) DEFAULT 'N',
  `SUB14` char(1) DEFAULT 'N',
  `SUB15` char(1) DEFAULT 'N',
  `SUB16` char(1) DEFAULT 'N',
  `SUB17` char(1) DEFAULT 'N',
  `SUB18` char(1) DEFAULT 'N',
  `SUB19` char(1) DEFAULT 'N',
  `SUB20` char(1) DEFAULT 'N',
  `SUB21` char(1) DEFAULT 'N',
  `SUB22` char(1) DEFAULT 'N',
  `SUB23` char(1) DEFAULT 'N',
  `SUB24` char(1) DEFAULT 'N',
  `SUB25` char(1) DEFAULT 'N',
  `SUB26` char(1) DEFAULT 'N',
  `ID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SEQNO`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbCOUNTRY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbCOUNTRY` (
  `COUNTRY_CODE` varchar(5) NOT NULL,
  `COUNTRY_NAME` varchar(30) DEFAULT NULL,
  `TAXNAME` varchar(5) DEFAULT NULL,
  `TAXNO_NAME` varchar(15) DEFAULT NULL,
  `TAX_IN_PP` char(1) DEFAULT 'N',
  PRIMARY KEY (`COUNTRY_CODE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbCREDIT_STATUSES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbCREDIT_STATUSES` (
  `STATUSNO` int(11) NOT NULL AUTO_INCREMENT,
  `STATUSDESC` varchar(30) DEFAULT NULL,
  `CREDIT_FACTOR` int(11) NOT NULL DEFAULT '0',
  `ACTIVE_DR` char(1) DEFAULT 'N',
  `ACTIVE_CR` char(1) DEFAULT 'N',
  `BAL_WARNING_SQL` varchar(60) DEFAULT NULL,
  `WARNING_TEXT` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`STATUSNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbCR_ACCS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbCR_ACCS` (
  `ACCNO` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(40) DEFAULT NULL,
  `ADDRESS1` varchar(30) DEFAULT NULL,
  `ADDRESS2` varchar(30) DEFAULT NULL,
  `ADDRESS3` varchar(30) DEFAULT NULL,
  `ADDRESS4` varchar(30) DEFAULT NULL,
  `ADDRESS5` varchar(30) DEFAULT NULL,
  `PHONE` varchar(30) DEFAULT NULL,
  `FAX` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(60) DEFAULT NULL,
  `CREDLIMIT` float DEFAULT '0',
  `ACCGROUP` int(11) DEFAULT '0',
  `LASTMONTH` float DEFAULT '0',
  `LASTYEAR` float DEFAULT '0',
  `AGEDBAL0` float DEFAULT '0',
  `AGEDBAL1` float DEFAULT '0',
  `AGEDBAL2` float DEFAULT '0',
  `AGEDBAL3` float DEFAULT '0',
  `BALANCE` float DEFAULT NULL,
  `CREDITSTATUS` int(11) DEFAULT '0',
  `OPENITEM` char(1) DEFAULT 'Y',
  `DELADDR1` varchar(30) DEFAULT NULL,
  `DELADDR2` varchar(30) DEFAULT NULL,
  `DELADDR3` varchar(30) DEFAULT NULL,
  `DELADDR4` varchar(30) DEFAULT NULL,
  `DELADDR5` varchar(30) DEFAULT NULL,
  `DELADDR6` varchar(30) DEFAULT NULL,
  `SALESNO` int(11) DEFAULT '0',
  `DISCOUNTLEVEL` int(11) DEFAULT '0',
  `INVOICETYPE` int(11) DEFAULT '0',
  `AUTOFREIGHT` float DEFAULT '0',
  `NOTES` text,
  `MONTHVAL` float DEFAULT '0',
  `YEARVAL` float DEFAULT '0',
  `ALPHACODE` varchar(15) DEFAULT NULL,
  `TAXSTATUS` int(11) DEFAULT '0',
  `HEAD_ACCNO` int(11) NOT NULL DEFAULT '-1',
  `CURRENCYNO` int(11) NOT NULL DEFAULT '0',
  `ALERT` varchar(60) DEFAULT NULL,
  `ISACTIVE` char(1) DEFAULT 'Y',
  `BANK_ACCOUNT` varchar(40) DEFAULT NULL,
  `DEFAULT_CODE` varchar(15) DEFAULT NULL,
  `BANK_ACC_NAME` varchar(40) DEFAULT NULL,
  `LAST_UPDATED` datetime DEFAULT NULL,
  `LEADTIME` int(11) DEFAULT '0',
  `TAXREG` varchar(30) DEFAULT NULL,
  `POST_CODE` varchar(12) DEFAULT NULL,
  `N_CR_DISC` float DEFAULT '0',
  `GLCONTROLACC` int(11) DEFAULT '0',
  `GLCONTROLSUBACC` int(11) DEFAULT '0',
  `BRANCHNO` int(11) DEFAULT '0',
  `PRIOR_AGEDBAL0` float DEFAULT '0',
  `PRIOR_AGEDBAL1` float DEFAULT '0',
  `PRIOR_AGEDBAL2` float DEFAULT '0',
  `PRIOR_AGEDBAL3` float DEFAULT '0',
  `PROMPT_PAY_DISC` float DEFAULT NULL,
  `BSBNO` varchar(40) DEFAULT NULL,
  `AUTO_AUTH_AMT` float DEFAULT NULL,
  `PAY_TYPE` int(11) DEFAULT '0',
  `PRIOR_BALANCE` float DEFAULT NULL,
  `ACCGROUP2` int(11) DEFAULT '0',
  `LEADTIME2` int(11) DEFAULT '0',
  `N_LAND_COST_PROVN` float DEFAULT '0',
  `PP_TOPAY` char(1) DEFAULT 'N',
  `STOPCREDIT` char(1) DEFAULT 'N',
  `DEF_INVMODE` int(11) NOT NULL DEFAULT '0',
  `PRIVATE_ACC` char(1) NOT NULL DEFAULT 'N',
  `WEBSITE` varchar(30) DEFAULT NULL,
  `AVE_DAYS_TO_PAY` int(11) NOT NULL DEFAULT '-1',
  `STATEMENT_TEXT` varchar(255) DEFAULT NULL,
  `REMITTANCE_METHOD` varchar(20) DEFAULT NULL,
  `SEND_PAYMENT_REMITTANCE` char(1) NOT NULL DEFAULT 'N',
  `STATEMENT_CONTACT_SEQNO` int(11) DEFAULT '-1',
  PRIMARY KEY (`ACCNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbCR_TRANS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbCR_TRANS` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `POSTTIME` datetime DEFAULT NULL,
  `TRANSDATE` datetime DEFAULT NULL,
  `ACCNO` int(11) DEFAULT '0',
  `TRANSTYPE` int(11) DEFAULT '0',
  `INVNO` varchar(20) DEFAULT NULL,
  `REF1` varchar(20) DEFAULT NULL,
  `REF2` varchar(20) DEFAULT NULL,
  `REF3` varchar(30) DEFAULT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `SUBTOTAL` float DEFAULT '0',
  `TAXTOTAL` float DEFAULT '0',
  `TAXINC` char(1) DEFAULT 'N',
  `ANALYSIS` varchar(12) DEFAULT NULL,
  `ALLOCATEDBAL` float DEFAULT '0',
  `ALLOCATED` char(1) DEFAULT '0',
  `ALLOCAGE` int(11) DEFAULT '0',
  `SALESNO` int(11) DEFAULT '0',
  `GLPOSTED` char(1) DEFAULT 'N',
  `GLCODE` int(11) DEFAULT NULL,
  `DUEDATE` datetime DEFAULT NULL,
  `BRANCH_ACCNO` int(11) DEFAULT NULL,
  `CONTACT_SEQNO` int(11) DEFAULT NULL,
  `CURRENCYNO` int(11) DEFAULT '0',
  `EXCHRATE` float DEFAULT '1',
  `GLSUBCODE` int(11) DEFAULT '0',
  `BRANCHNO` int(11) DEFAULT '0',
  `PO_SEQNO` int(11) DEFAULT '0',
  `TAXRATE` float DEFAULT '0',
  `TAXRATE_NO` int(11) DEFAULT '0',
  `PREV_PERIOD_OPEN` float DEFAULT '0',
  `PAYSTATUS` int(11) DEFAULT '0',
  `AUTHORISED` char(1) DEFAULT 'N',
  `AUTHORISEDBY` int(11) DEFAULT NULL,
  `AUTH_DATE` datetime DEFAULT NULL,
  `UNREALISED_GAINS_GL_BATCH` int(11) NOT NULL DEFAULT '0',
  `TAXRETCODE` varchar(15) DEFAULT NULL,
  `N_TOTVENDISC` float DEFAULT '0',
  `RELEASEDAMT` float DEFAULT '0',
  `PURCH_ACCNO` int(11) DEFAULT NULL,
  `RECEIPTNO` int(11) DEFAULT '0',
  `N_TOTVENDISC_EXCLTAX` float DEFAULT '0',
  `GLBATCHNO` int(11) DEFAULT NULL,
  `TOAGEDBAL` int(11) DEFAULT NULL,
  `NARRATIVE_SEQNO` int(11) DEFAULT NULL,
  `IMAGE_URL` varchar(80) DEFAULT NULL,
  `MANUAL_ROUNDING` float NOT NULL DEFAULT '0',
  `AMOUNT` float DEFAULT NULL,
  `PREV_PERIOD_CLOSE` float DEFAULT '0',
  `TXID` varbinary(256) DEFAULT NULL,
  `PTNO` int(11) DEFAULT '-1',
  `SESSION_ID` int(11) DEFAULT '-1',
  `PERIOD_SEQNO` int(11) NOT NULL DEFAULT '0',
  `AGE_STAMP` int(11) DEFAULT '-1',
  `AGE` int(11) DEFAULT NULL,
  `BANKNO` int(11) DEFAULT NULL,
  PRIMARY KEY (`SEQNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbCURRENCIES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbCURRENCIES` (
  `CURRENCYNO` int(11) NOT NULL AUTO_INCREMENT,
  `CURRCODE` varchar(3) DEFAULT NULL,
  `CURRNAME` varchar(30) DEFAULT NULL,
  `BUYRATE` float DEFAULT NULL,
  `SELLRATE` float DEFAULT NULL,
  `CURRSYMBOL` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`CURRENCYNO`),
  UNIQUE KEY `CURRNAME` (`CURRNAME`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbConfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleName` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `description` tinytext NOT NULL,
  `sortOrder` int(11) NOT NULL DEFAULT '1',
  `langid` int(5) NOT NULL,
  `params` text NOT NULL,
  `default` tinytext NOT NULL,
  `isCore` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `moduleName` (`moduleName`),
  KEY `language` (`langid`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbConfig` VALUES (1,'site','company','InfoSysPro','This is the name of the company that will be displayed through out the site',1,1,'','',1),(2,'site','allowedFailedLoginAttempts','3','This is the value used to monitor how many failed log in attempts should be used before the user can be locked out of the system for a certain period of time',1,9999,'','',1),(3,'site','maximumLockOutFailedLoginAttemptsTime','30','Maximum time the user should wait in minutes before they ca be allowed login',1,9999,'','',1),(4,'site','useCache','false','Enable caching in order to boost performance',1,9999,'','',1),(5,'User','lockUsers','1','Lock users if the supply X number of failed login attempts; 1 = Yes and 0 = No',1,9999,'','',1),(6,'User','allowRegistration','1','Allow users to register on the site options are 1 = Yes and 0 = No',1,9999,'','',1),(7,'mailConfig','mail.useSmtp','1','Whether to use the default php mail function or the company\'s mailserver\r\n1 = Yes, 0 = No',1,9999,'','',1),(8,'mailConfig','mail.host','pop.infosyspro.com.au','the server of from which emails will be relayed through. Check if relaying of this site\'s IP is allowed',2,9999,'','',1),(9,'mailConfig','mail.username','doabile@infosyspro.com.au','username if the SMTP requires authentication ',3,9999,'','',1),(10,'mailConfig','mail.password','dailer12','Password for the SMTP if authentication is allowed ',4,9999,'','',1),(11,'mailConfig','mail.auth','login','Does our mail server require authentication? if yes what method is used examples are Crammd5 or Login or Plain. Check with your IT company. LEAVE BLANK to disable this',1,9999,'','',1),(12,'mailConfig','mail.port','587','The SMTP port the mailserver uses',5,9999,'','',1),(13,'mailConfig','mail.sentFrom','doabile@infosyspro.com.au','Sender\'s email',6,9999,'','',1),(14,'mailConfig','mail.name','','the name of the mail server',7,9999,'','',1),(15,'mailConfig','mail.useHtml','1','Use html email body otherwise use plain text. 1 = Yes and 0 = No',8,9999,'','',1),(16,'mailConfig','mail.CCTo','support@infosyspro.com.au','email address to cc all emails to. LEAVE BLANK if none',9,9999,'','',1),(18,'mailConfig','mail.sentFromName','Tirelo Oabile','test duplicated',1,9999,'','',1),(19,'formData','errorIncorrectData','Incorrect data detected in %s','Error displayed when there is data validation error',1,1,'','',1),(20,'site','siteOffline','0','determine if the site is offline or not',1,9999,'','',1),(21,'site','offlineMessage','This site is down for maintenance.<br /> Please check back again soon.','Message displayed when the site is offline',1,1,'','',1),(22,'site','defaultAccessLevel','Public','Default group to view the contents of the site',1,1,'','',1),(23,'template','template.fontFamily','mynxx','Font family for the site layout',1,9999,'','',1),(24,'template','template.width','959','Template width',1,9999,'','',1),(25,'template','template.leftColumnWidth','210','Left column width',1,9999,'','',1),(26,'template','template.rightColumnWidth','210','Right column width',1,9999,'','',1),(27,'template','template.leftInsetWidth','180','Left Insert width',1,9999,'','',1),(28,'template','template.rightInsetWidth','180','Right Insert width',1,9999,'','',1),(29,'template','template.SideMenu','mainmenu','Menu displayed on the side of the template',1,9999,'','',1),(30,'template','template.defaultFont','default','Default font used trought the template',1,9999,'','',1),(31,'template','template.showLogo','true','Enable logo visibility',1,1,'','',1),(32,'template','template.showLogoSlogan','true','show logo slogan ',1,9999,'','',1),(33,'template','template.logoSlogan','Something about me','Slogan text',1,9999,'','',1),(34,'template','template.showBottomLogo','true','Show logo at the bottom of the page',1,9999,'','',1),(35,'template','template.showHomebutton','true','Show the home button icom',1,9999,'','',1),(36,'template','template.showCart','true','Show cart on the home page',1,9999,'','',1),(37,'template','template.showCopyright','true','Show copyright text at the bottom of the page',1,9999,'','',1),(38,'template','template.language','en','language used for this site',1,1,'','',1),(39,'stockItems','maxDisplayNewProducts','6','Maximum number of new products to display. These are known as new arrivals ',1,1,'','',1),(40,'stockItems','baseprice','1','This is default price that will be used on the web. Use the number in the stockItems sellprice1 to 10',1,1,'','',1),(41,'stockItems','UseStockGroupField','stockpricegroup','Set the group which is used for best price policy; expects either STOCKGROUP or STOCKPRICEGROUP',1,1,'','',1),(42,'stockItems','taxRateId','10','Default tax rate to be used. PRIORITY of EXECUTION: if product tax is set this will take precedence: if customer tax is set, then that tax will be used otherwise this id will be used ',1,1,'','10',1),(43,'stockItems','displayPriceWithTax','both','Should prices be displayed with or without GST. Options are: both => display both INC GST and EX GST, true : INC GST and or false: EX GST',1,1,'','both',1),(44,'stockItems','defaultCurrency','{ \"defaultCurrency\" : \"AUD\", \"symbol\" : \"(AUD)\", \"format\" : \"en\", \"position\" : \"LEFT\" }','Default currency to be used\r\nUse any valid country currency\r\nSymbol: any symbol that you want e.g. $$$$, $ or dollars\r\nFormat: any format that you want en for english ar etc\r\nposition: Is the position where you want the symbol to be placed',1,1,'','{ \"defaultCurrency\" : \"AUD\", \"symbol\" : \"(AUD)\", \"format\" : \"en\", \"position\" : \"LEFT\" }',1),(45,'stockItems','stockItemGroupOrder','STOCKCODE ASC','This is how you want stockitem groups to be displayed on the website. Any valid field is allowed DESC means Z -A while ASC means A-Z',1,1,'','STOCKCODE ASC',1),(46,'stockItems','stockItemProductsOrder','STOCKCODE ASC','This is how you want stockitems to be displayed on the website. Any valid field is allowed DESC means Z -A while ASC means A-Z',1,1,'','STOCKCODE ASC',1);
DROP TABLE IF EXISTS `TbConfigGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbConfigGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(30) NOT NULL,
  `groupName` varchar(50) NOT NULL COMMENT 'Group name ',
  `description` tinytext NOT NULL,
  `package` varchar(30) NOT NULL COMMENT 'package type std, lite, premium',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mod_name` (`mod_name`),
  KEY `groupName` (`groupName`),
  KEY `package` (`package`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Container to hold TbConfig groupings';
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbConfigGroup` VALUES (2,'mailConfig','Emaill Set Up','Configuring the company email settings e.g. SMPT server, username and password','lite'),(3,'template','Template Settings','This where we configure the things like the look and feel of your website e.g. template size','lite'),(4,'site','Site Setting','This configures your website e.g. site name, security settings and more','standard'),(5,'User','Customer Settings','This controls what customers can do on your site .e. registration, changing addresses ','standard'),(6,'stockItems','Stock Items','Manage stock items','standard');
DROP TABLE IF EXISTS `TbContent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbContent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) NOT NULL COMMENT 'Controller  ActionName ID',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `content_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'is this an article or blog',
  `introtext` mediumtext NOT NULL,
  `fulltext` longtext NOT NULL,
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_state` (`published`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`),
  KEY `idx_language` (`language`),
  KEY `action` (`action`),
  FULLTEXT KEY `action_2` (`action`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbContent` VALUES (1,'indexIndex','Administrator Components','administrator-components','','<p>All components also are used in the administrator area of your website. In addition to the ones listed here, there are components in the administrator that do not have direct front end displays, but do help shape your site. The most important ones for most users are .......</p>','<p>All components also are used in the administrator area of your website. In addition to the ones listed here, there are components in the administrator that do not have direct front end displays, but do help shape your site. The most important ones for most users are</p>\n<ul>\n<li>Media Manager</li>\n<li>Extensions Manager</li>\n<li>Menu Manager</li>\n<li>Global Configuration</li>\n<li>Banners</li>\n<li>Redirect</li>\n</ul>\n<hr class=\"system-pagebreak\" style=\"color: gray; border: 1px dashed gray;\" title=\"Media Manager\" />\n<p>&nbsp;</p>\n<h3>Media Manager</h3>\n<p>The media manager component lets you upload and insert images into content throughout your site. Optionally, you can enable the flash uploader which will allow you to to upload multiple images. <a href=\"http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Content_Media_Manager\">Help</a></p>\n<hr class=\"system-pagebreak\" style=\"color: gray; border: 1px dashed gray;\" title=\"Extensions Manager\" />\n<h3>Extensions Manager</h3>\n<p>The extensions manager lets you install, update, uninstall and manage all of your extensions. The extensions manager has been extensively redesigned for Joomla! 1.6, although the core install and uninstall functionality remains the same as in Joomla 1.5. <a href=\"http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Extensions_Extension_Manager_Install\">Help</a></p>\n<hr class=\"system-pagebreak\" style=\"color: gray; border: 1px dashed gray;\" title=\"Menu Manager\" />\n<h3>Menu Manager</h3>\n<p>The menu manager lets you create the menus you see displayed on your site. It also allows you to assign modules and template styles to specific menu links. <a href=\"http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Menus_Menu_Manager\">Help</a></p>\n<hr class=\"system-pagebreak\" style=\"color: gray; border: 1px dashed gray;\" title=\"Global Configuration\" />\n<h3>Global Configuration</h3>\n<p>The global configuration is where the site administrator configures things such as whether search engine friendly urls are enabled, the site meta data (descriptive text used by search engines and indexers) and other functions. For many beginning users simply leaving the settings on default is a good way to begin, although when your site is ready for the public you will want to change the meta data to match its content. <a href=\"http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Site_Global_Configuration\">Help</a></p>\n<hr class=\"system-pagebreak\" style=\"color: gray; border: 1px dashed gray;\" title=\"Banners\" />\n<h3>Banners</h3>\n<p>The banners component provides a simple way to display a rotating image in a module and, if you wish to have advertising, a way to track the number of times an image is viewed and clicked. <a href=\"http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Components_Banners_Banners_Edit\">Help</a></p>\n<hr class=\"system-pagebreak\" title=\"Redirect\" />\n<h3><br />Redirect</h3>\n<p>The redirect component is used to manage broken links that produce Page Not Found (404) errors. If enabled it will allow you to redirect broken links to specific pages. It can also be used to manage migration related URL changes. <a href=\"http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help16:Components_Redirect_Manager\">Help</a></p>\n<p>&nbsp;</p>\n<hr class=\"system-pagebreak\" style=\"color: gray; border: 1px dashed gray;\" title=\"Banners\" />\n<p>&nbsp;</p>\n<p>the resr everyone can do</p>\n<p>&nbsp;</p>',1,'2011-01-01 00:00:01',42,'2012-02-21 00:00:00',42,'2011-01-01 00:00:01','0000-00-00 00:00:00','','','{\"created_by\":\"David Oabile\",\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"1\",\"show_vote\":\"0\"}',7,'testing keys','testing description',1,4892,'{\"robots\":\"\"}',0,'en'),(2,'article-my-first-article','my first article','my first article','article','<p>my first article</p>','<p>my first article</p>',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"created_by\":\"David\",\"show_title\":\"1\",\"show_intro\":\"1\",\"show_create_date\":\"1\",\"show_hits\":\"1\",\"show_vote\":\"1\"}',0,'my first article','my first article',1,0,'{\"robots\":\"\",\"author\":\"\"}',0,'en'),(3,'article-my-second-article','my second article','my second article','article','<p>I learned all my trading strategies and plans from <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a>. <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a> is always creating new and exciting products to assist day traders. Its products and services now include:</p>','<p>I learned all my trading strategies and plans from <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a>. <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a> is always creating new and exciting products to assist day traders. Its products and services now include:</p>\n<p>Rockwell Trading Home Study Course: - A 6 DVD set accompanied by an online video library for both the new and veteran trader. The Home Study Course includes over 50 video tutorials detailing Rockwell&rsquo;s day trading strategies, chart reading, technical analysis, popular indicators, and so much more. In total, this is 7 hours of prime information that can benefit most anyone. Members get 24 hour access and lifetime privileges to the growing video library.</p>\n<p>These guys are good and they won\'t charge you a lot. They will teach you many strategies or you can come and follow my strategy, it is 80% similar to <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell trading</a>.&nbsp; Check them out <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">http://www.rockwelltrading.com</a></p>\n<p>Other than that, I hope you are well and I look forward to catching up with you soon.&nbsp; Maybe we can compare our winning trading plans...</p>',0,'2012-02-20 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"created_by\":\"David\",\"show_title\":\"1\",\"show_intro\":\"1\",\"show_create_date\":\"1\",\"show_hits\":\"0\",\"show_vote\":\"1\"}',0,'trading','trading ',1,0,'{\"robots\":\"\",\"author\":\"\"}',0,'en'),(4,'article-my-second-blog','My second Blog','second-blog','article','<p>I learned all my trading strategies and plans from <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a>. <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a> is always creating new and exciting products to assist day traders. Its products and services now include:</p>','<p>I learned all my trading strategies and plans from <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a>. <a href=\"https://rockwell.infusionsoft.com/go/eBook/doabile/\">Rockwell Trading</a> is always creating new and exciting products to assist day traders. Its products and services now include:</p>',1,'2012-02-20 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"created_by\":\"Davido\",\"show_title\":\"1\",\"show_intro\":\"1\",\"show_create_date\":\"0\",\"show_hits\":\"1\",\"show_vote\":\"0\"}',0,'keys','artcle',1,0,'{\"robots\":\"\",\"author\":\"\"}',0,'en'),(5,'firstblogpost','First Blog Post','first-blog-post','blog','<p><em>Lorem Ipsum is filler text that is commonly used by designers before the content for a new site is ready.</em></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed faucibus purus vitae diam posuere nec eleifend elit dictum. Aenean sit amet erat purus, id fermentum lorem. Integer elementum tristique lectus, non posuere quam pretium sed. Quisque scelerisque erat at urna condimentum euismod. Fusce vestibulum facilisis est, a accumsan massa aliquam in. In auctor interdum mauris a luctus. Morbi euismod tempor dapibus. Duis dapibus posuere quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In eu est nec erat sollicitudin hendrerit. Pellentesque sed turpis nunc, sit amet laoreet velit. Praesent vulputate semper nulla nec varius. Aenean aliquam, justo at blandit sodales, mauris leo viverra orci, sed sodales mauris orci vitae magna.</p>','<p>Quisque a massa sed libero tristique suscipit. Morbi tristique molestie metus, vel vehicula nisl ultrices pretium. Sed sit amet est et sapien condimentum viverra. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus viverra tortor porta orci convallis ac cursus erat sagittis. Vivamus aliquam, purus non luctus adipiscing, orci urna imperdiet eros, sed tincidunt neque sapien et leo. Cras fermentum, dolor id tempor vestibulum, neque lectus luctus mauris, nec congue tellus arcu nec augue. Nulla quis mi arcu, in bibendum quam. Sed placerat laoreet fermentum. In varius lobortis consequat. Proin vulputate felis ac arcu lacinia adipiscing. Morbi molestie, massa id sagittis luctus, sem sapien sollicitudin quam, in vehicula quam lectus quis augue. Integer orci lectus, bibendum in fringilla sit amet, rutrum eget enim. Curabitur at libero vitae lectus gravida luctus. Nam mattis, ligula sit amet vestibulum feugiat, eros sem sodales mi, nec dignissim ante elit quis nisi. Nulla nec magna ut leo convallis sagittis ac non erat. Etiam in augue nulla, sed tristique orci. Vestibulum quis eleifend sapien.</p><p>Nam ut orci vel felis feugiat posuere ut eu lorem. In risus tellus, sodales eu eleifend sed, imperdiet id nulla. Nunc at enim lacus. Etiam dignissim, arcu quis accumsan varius, dui dui faucibus erat, in molestie mauris diam ac lacus. Sed sit amet egestas nunc. Nam sollicitudin lacinia sapien, non gravida eros convallis vitae. Integer vehicula dui a elit placerat venenatis. Nullam tincidunt ligula aliquet dui interdum feugiat. Maecenas ultricies, lacus quis facilisis vehicula, lectus diam consequat nunc, euismod eleifend metus felis eu mauris. Aliquam dapibus, ipsum a dapibus commodo, dolor arcu accumsan neque, et tempor metus arcu ut massa. Curabitur non risus vitae nisl ornare pellentesque. Pellentesque nec ipsum eu dolor sodales aliquet. Vestibulum egestas scelerisque tincidunt. Integer adipiscing ultrices erat vel rhoncus.</p><p>Integer ac lectus ligula. Nam ornare nisl id magna tincidunt ultrices. Phasellus est nisi, condimentum at sollicitudin vel, consequat eu ipsum. In venenatis ipsum in ligula tincidunt bibendum id et leo. Vivamus quis purus massa. Ut enim magna, pharetra ut condimentum malesuada, auctor ut ligula. Proin mollis, urna a aliquam rutrum, risus erat cursus odio, a convallis enim lectus ut lorem. Nullam semper egestas quam non mattis. Vestibulum venenatis aliquet arcu, consectetur pretium erat pulvinar vel. Vestibulum in aliquet arcu. Ut dolor sem, pellentesque sit amet vestibulum nec, tristique in orci. Sed lacinia metus vel purus pretium sit amet commodo neque condimentum.</p><p>Aenean laoreet aliquet ullamcorper. Nunc tincidunt luctus tellus, eu lobortis sapien tincidunt sed. Donec luctus accumsan sem, at porttitor arcu vestibulum in. Sed suscipit malesuada arcu, ac porttitor orci volutpat in. Vestibulum consectetur vulputate eros ut porttitor. Aenean dictum urna quis erat rutrum nec malesuada tellus elementum. Quisque faucibus, turpis nec consectetur vulputate, mi enim semper mi, nec porttitor libero magna ut lacus. Quisque sodales, leo ut fermentum ullamcorper, tellus augue gravida magna, eget ultricies felis dolor vitae justo. Vestibulum blandit placerat neque, imperdiet ornare ipsum malesuada sed. Quisque bibendum quam porta diam molestie luctus. Sed metus lectus, ornare eu vulputate vel, eleifend facilisis augue. Maecenas eget urna velit, ac volutpat velit. Nam id bibendum ligula. Donec pellentesque, velit eu convallis sodales, nisi dui egestas nunc, et scelerisque lectus quam ut ipsum.</p>',1,'2011-01-01 00:00:01',42,'2011-01-01 00:00:01',42,'2011-01-01 00:00:01','0000-00-00 00:00:00','/media/site/images/boat.jpg','','{\"show_title\":\"1\",\"link_titles\":\"\",\"show_intro\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_readmore\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_hits\":\"\",\"page_title\":\"\",\"alternative_readmore\":\"\",\"layout\":\"\"}',0,'','',1,153,'',0,'en'),(8,'','test 3','article-test-3','article','â€‹sfsfsfsfs <br>','â€‹me tges<br>',1,'2012-03-11 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(9,'','testt tetst','article-testt-tetst','article','â€‹IE??','â€‹IE test&nbsp;&nbsp;&nbsp;&nbsp;',1,'2012-03-11 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(10,'','test44','article-test44','article','â€‹tedywfydtwyfdywftd','â€‹test 44 etes4 <br>',1,'2012-03-11 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(11,'','test 55','article-test-55','article','â€‹retss','â€‹test 55 555<br>',1,'2012-03-11 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(12,'','test 555','article-test-555','article','â€‹retss5','â€‹test 55 5555<br>',1,'2012-03-11 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(13,'','Test us me the','article-test-us-me-the','article','â€‹Thes is a tes','â€‹This is fine the way it s',2,'2012-03-13 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"0\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(14,'','david test','article-david-test','article','â€‹â€‹test more more moe more more','â€‹test more more moe more more<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(15,'','david test2','article-david-test2','article','â€‹â€‹test more more moe more mores','â€‹test more more moe more mores<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(16,'','david test4','article-david-test4','article','â€‹â€‹test more more moe more mores4','â€‹test more more moe more mores4<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(17,'','david test5','article-david-test5','article','â€‹â€‹test more more moe more mores45','â€‹test more more moe more mores45<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(18,'','david test56','article-david-test56','article','â€‹â€‹test more more moe more mores456','â€‹test more more moe more mores456<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(19,'','david test567','article-david-test567','article','â€‹â€‹test more more moe more mores4567','â€‹test more more moe more mores4567<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(20,'','david test5675','article-david-test5675','article','â€‹â€‹test more more moe more mores45675','â€‹test more more moe more mores45675<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(21,'','david test56754','article-david-test56754','article','â€‹â€‹test more more moe more mores456754','â€‹test more more moe more mores456754<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(22,'','david test567544','article-david-test567544','article','â€‹â€‹test more more moe more mores45675444','â€‹test more more moe more mores45675444<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(23,'','david test5675443','article-david-test5675443','article','â€‹â€‹test more more moe more mores456754443','â€‹test more more moe more mores456754443<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en'),(24,'','david test56754432','article-david-test56754432','article','â€‹â€‹test more more moe more mores4567544432','â€‹test more more moe more mores456754443 2<br>',1,'2012-03-17 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','','','{\"show_title\":\"1\",\"show_author\":\"1\",\"show_intro\":\"0\",\"show_create_date\":\"1\",\"show_modify_date\":\"0\",\"show_hits\":\"0\",\"show_vote\":\"0\"}',0,'','',1,0,'',0,'en');
DROP TABLE IF EXISTS `TbDR_ACCS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbDR_ACCS` (
  `ACCNO` int(11) NOT NULL,
  `FIRSTNAME` varchar(32) DEFAULT NULL,
  `LASTNAME` varchar(32) DEFAULT NULL,
  `DOB` datetime DEFAULT NULL,
  `SALUTATION` int(11) DEFAULT '1',
  `USERNAME` varchar(32) NOT NULL,
  `COMPANY` varchar(40) DEFAULT NULL,
  `ADDRESS1` varchar(30) DEFAULT NULL,
  `ADDRESS2` varchar(30) DEFAULT NULL,
  `ADDRESS3` varchar(30) DEFAULT NULL,
  `ADDRESS4` varchar(30) DEFAULT NULL,
  `ADDRESS5` varchar(30) DEFAULT NULL,
  `DELADDR1` varchar(30) DEFAULT NULL,
  `DELADDR2` varchar(30) DEFAULT NULL,
  `DELADDR3` varchar(30) DEFAULT NULL,
  `DELADDR4` varchar(30) DEFAULT NULL,
  `DELADDR5` varchar(30) DEFAULT NULL,
  `DELADDR6` varchar(30) DEFAULT NULL,
  `PHONE` varchar(30) DEFAULT NULL,
  `FAX` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(60) DEFAULT NULL,
  `CREDLIMIT` float DEFAULT '0',
  `ACCGROUP` int(11) DEFAULT '0',
  `SALESNO` int(11) DEFAULT '0',
  `LASTMONTH` float DEFAULT '0',
  `LASTYEAR` float DEFAULT '0',
  `AGEDBAL0` float DEFAULT '0',
  `AGEDBAL1` float DEFAULT '0',
  `AGEDBAL2` float DEFAULT '0',
  `AGEDBAL3` float DEFAULT '0',
  `CREDITSTATUS` int(11) DEFAULT '0',
  `DISCOUNTLEVEL` int(11) DEFAULT '0',
  `OPENITEM` char(1) DEFAULT 'Y',
  `INVOICETYPE` int(11) DEFAULT '0',
  `NOTES` varchar(4096) DEFAULT NULL,
  `MONTHVAL` float DEFAULT '0',
  `YEARVAL` float DEFAULT '0',
  `STARTDATE` datetime DEFAULT NULL,
  `SORTCODE` varchar(12) DEFAULT NULL,
  `BANK` varchar(20) DEFAULT NULL,
  `BANK_ACCOUNT` varchar(40) DEFAULT NULL,
  `BANK_ACC_NAME` varchar(40) DEFAULT NULL,
  `BSBNO` varchar(40) DEFAULT NULL,
  `D_DEBIT_FAX` char(1) DEFAULT 'N',
  `D_DEBIT_PRINT` char(1) DEFAULT 'N',
  `D_DEBIT_EMAIL` char(1) DEFAULT 'N',
  `PAY_TYPE` int(11) DEFAULT '0',
  `BRANCH` varchar(30) DEFAULT NULL,
  `DRAWER` varchar(30) DEFAULT NULL,
  `TAXSTATUS` int(11) DEFAULT '0',
  `PRICENO` int(11) DEFAULT '1',
  `AUTOBILLCODE` varchar(23) DEFAULT NULL,
  `ALPHACODE` varchar(15) DEFAULT NULL,
  `HEAD_ACCNO` int(11) NOT NULL DEFAULT '-1',
  `PASS_WORD` varchar(30) DEFAULT NULL,
  `CURRENCYNO` int(11) NOT NULL DEFAULT '0',
  `ALERT` varchar(255) DEFAULT NULL,
  `STATEMENT` char(1) DEFAULT 'Y',
  `INVFILENO` int(11) DEFAULT '0',
  `PROMPTPAY_PC` float DEFAULT '0',
  `PROMPTPAY_AMT` float DEFAULT '0',
  `ISACTIVE` char(1) DEFAULT 'Y',
  `BAD_CHEQUE` char(1) DEFAULT 'N',
  `BRANCHNO` int(11) DEFAULT '0',
  `LAST_UPDATED` datetime DEFAULT NULL,
  `TAXREG` varchar(30) DEFAULT NULL,
  `STOPCREDIT` char(1) DEFAULT 'N',
  `POST_CODE` varchar(12) DEFAULT NULL,
  `GLCONTROLACC` int(11) DEFAULT '0',
  `GLCONTROLSUBACC` int(11) DEFAULT '0',
  `PRIOR_AGEDBAL0` float DEFAULT '0',
  `PRIOR_AGEDBAL1` float DEFAULT '0',
  `PRIOR_AGEDBAL2` float DEFAULT '0',
  `PRIOR_AGEDBAL3` float DEFAULT '0',
  `BALANCE` float DEFAULT NULL,
  `PRIOR_BALANCE` float DEFAULT NULL,
  `ACCGROUP2` int(11) DEFAULT '0',
  `FREIGHT_FREE` char(1) NOT NULL DEFAULT 'N',
  `COURIER_DEPOT_SEQNO` int(11) DEFAULT NULL,
  `KEEPTRANSACTIONS` char(1) NOT NULL DEFAULT 'Y',
  `NEED_ORDERNO` char(1) NOT NULL DEFAULT 'N',
  `PRICEGROUP` int(11) DEFAULT '0',
  `ALLOW_RESTRICTED_STOCK` char(1) NOT NULL DEFAULT 'Y',
  `PRIVATE_ACC` char(1) NOT NULL DEFAULT 'N',
  `WEBSITE` varchar(50) DEFAULT NULL,
  `AVE_DAYS_TO_PAY` int(11) NOT NULL DEFAULT '-1',
  `INVOICE_TYPE` varchar(20) DEFAULT 'DEFAULT',
  `STATEMENT_CONTACT_SEQNO` int(11) DEFAULT '-1',
  `WEB_ACTIVE` char(1) DEFAULT 'Y',
  `NEWSLETTER` char(1) DEFAULT NULL,
  `PRICEBANDNO` float NOT NULL,
  PRIMARY KEY (`ACCNO`),
  UNIQUE KEY `USERNAME` (`USERNAME`),
  KEY `EMAIL` (`EMAIL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbDR_PRICES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbDR_PRICES` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `ACCNO` int(11) DEFAULT '0',
  `STOCKCODE` varchar(23) DEFAULT NULL,
  `PRICE` float DEFAULT '0',
  `STARTDATE` datetime DEFAULT NULL,
  `STOPDATE` datetime DEFAULT NULL,
  `MINQTY` float DEFAULT '0',
  `ACCGROUP` int(11) DEFAULT '-1',
  `STOCKPRICEGROUP` int(11) DEFAULT '-1',
  `DISCOUNT` float DEFAULT NULL,
  `FREIGHT_FREE` char(1) NOT NULL DEFAULT 'N',
  `POLICY_HDR` int(11) DEFAULT NULL,
  `SELL_PRICE_BANDNO` int(11) NOT NULL DEFAULT '-1',
  `MASTER_JOBNO` int(11) DEFAULT '0',
  `JOBNO` int(11) DEFAULT '0',
  PRIMARY KEY (`SEQNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbLanguages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbLanguages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbLanguages` VALUES (1,'en-GB','English','English','en','en','','','','',1,1);
DROP TABLE IF EXISTS `TbLogName`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbLogName` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `message` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbLogName` VALUES (1,6,'addLog called on Infosys\\Log\\Log, using params {\"message\":\"Testing what will happen\",\"level\":0}'),(2,6,'addLog called on , using params {\"message\":\"Testing static usage what will happen\",\"level\":0}'),(3,6,'addLog called on , using params {\"message\":\"Testing static usage what will happen\",\"level\":0}'),(4,6,'addLog called on , using params {\"message\":\"Testing static usage what will happen\",\"level\":0}'),(5,6,'addLog called on , using params {\"message\":\"Testing static usage what will happen\",\"level\":0}'),(6,6,'addLog called on , using params {\"message\":\"Testing static usage what will happen\",\"level\":0}'),(7,6,'addLog triggered using params {\"message\":\"Testing static usage what will happen\",\"level\":0}'),(8,6,'addLog triggered using params {\"message\":\"Testing static usage what will happen\",\"level\":0}');
DROP TABLE IF EXISTS `TbMENU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbMENU` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENUTYPE` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `TITLE` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `ALIAS` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `NOTE` varchar(255) NOT NULL DEFAULT '',
  `PATH` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `LINK` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `TYPE` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `PUBLISHED` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `PARENT_ID` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `LEVEL` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `ORDERING` int(11) NOT NULL DEFAULT '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `APPROVED` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `BROWSERNAV` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `ACCESS` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `IMG` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `PARAMS` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `HOME` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `LANGUAGE` char(7) NOT NULL DEFAULT '',
  `CLIENT_ID` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `idx_client_id_parent_id_alias` (`CLIENT_ID`,`PARENT_ID`,`ALIAS`),
  KEY `idx_menutype` (`MENUTYPE`),
  KEY `idx_alias` (`ALIAS`),
  KEY `idx_path` (`PATH`(333)),
  KEY `idx_LANGUAGE` (`LANGUAGE`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbMENU` VALUES (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,0,'0000-00-00 00:00:00',0,0,'',0,'',0,277,0,'*',0),(2,'menu','com_banners','Banners','','Banners','index.php?option=com_banners','component',0,1,1,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',13,22,0,'*',1),(3,'menu','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',14,15,0,'*',1);
DROP TABLE IF EXISTS `TbMessageCenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbMessageCenter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` longtext NOT NULL,
  `language` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbSALESORD_HDR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSALESORD_HDR` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `STATUS` int(11) DEFAULT '0',
  `ACCNO` int(11) DEFAULT '0',
  `ORDERDATE` datetime DEFAULT NULL,
  `DUEDATE` datetime DEFAULT NULL,
  `CUSTORDERNO` varchar(20) DEFAULT NULL,
  `REFERENCE` varchar(20) DEFAULT NULL,
  `ADDRESS1` varchar(30) DEFAULT NULL,
  `ADDRESS2` varchar(30) DEFAULT NULL,
  `ADDRESS3` varchar(30) DEFAULT NULL,
  `ADDRESS4` varchar(30) DEFAULT NULL,
  `INSTRUCTIONS` varchar(255) DEFAULT NULL,
  `SUBTOTAL` float DEFAULT '0',
  `TAXTOTAL` float DEFAULT '0',
  `SALESNO` int(11) DEFAULT '0',
  `CONTACT_SEQNO` int(11) DEFAULT NULL,
  `CURRENCYNO` int(11) DEFAULT '0',
  `EXCHRATE` float DEFAULT '1',
  `CONSIGNTOLOC` int(11) DEFAULT '0',
  `BRANCHNO` int(11) DEFAULT '0',
  `TAXINC` char(1) DEFAULT 'N',
  `BACKORDER` char(1) DEFAULT 'N',
  `MANIFEST` int(11) DEFAULT '0',
  `DISPATCH_INFO` varchar(70) DEFAULT NULL,
  `HSTATUS` int(11) DEFAULT NULL,
  `LAST_UPDATED` datetime DEFAULT NULL,
  `ADDRESS5` varchar(30) DEFAULT NULL,
  `ADDRESS6` varchar(30) DEFAULT NULL,
  `PAYMENT_STATUS` int(11) DEFAULT '0',
  `ORDTOTAL` float DEFAULT NULL,
  `DELIVERYCOUNT` int(11) NOT NULL DEFAULT '0',
  `INVOICECOUNT` int(11) NOT NULL DEFAULT '0',
  `NARRATIVE_SEQNO` int(11) DEFAULT NULL,
  `HAS_UNRELEASED` char(1) NOT NULL DEFAULT 'N',
  `HAS_BACKORDERS` char(1) NOT NULL DEFAULT 'N',
  `HAS_UNSUPPLIED` char(1) NOT NULL DEFAULT 'N',
  `HAS_UNINVOICED` char(1) NOT NULL DEFAULT 'N',
  `HAS_UNPICKED` char(1) NOT NULL DEFAULT 'N',
  `PICKEDCOUNT` int(11) DEFAULT '0',
  `RELEASECOUNT` int(11) DEFAULT '0',
  `ORDSTATUS` int(11) DEFAULT '0',
  `DEFLOCNO` int(11) DEFAULT '0',
  `PROCESSFINALISATION` int(11) DEFAULT '0',
  `MAXCOURIERCHARGE` float DEFAULT '0',
  `SHIP_COMPLETE` char(1) NOT NULL DEFAULT 'N',
  `TXID` varbinary(256) DEFAULT NULL,
  `ONHOLD` char(1) DEFAULT 'N',
  `TAXROUNDING` float NOT NULL DEFAULT '0',
  `CREATE_DATE` datetime DEFAULT NULL,
  `ACTIVATION_DATE` datetime DEFAULT NULL,
  `FINALISATION_DATE` datetime DEFAULT NULL,
  `WAS_BACKORDERED` char(1) DEFAULT 'N',
  `X_OPPORTUNITY_SEQNO` int(11) DEFAULT '-1',
  `OPPORTUNITY_SEQNO` int(11) DEFAULT '-1',
  `xweb_paymentmethod` varchar(50) DEFAULT NULL,
  `XWEB_TOUPDATE` char(1) NOT NULL DEFAULT 'N',
  `X_CONSIGNMENTREF` varchar(20) DEFAULT NULL,
  `X_SEND_EMAIL_DISPATCH` char(1) DEFAULT 'N',
  PRIMARY KEY (`SEQNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbSALESORD_LINES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSALESORD_LINES` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `ACCNO` int(11) DEFAULT '0',
  `HDR_SEQNO` int(11) DEFAULT '0',
  `STOCKCODE` varchar(23) DEFAULT NULL,
  `DESCRIPTION` varchar(40) DEFAULT NULL,
  `ORD_QUANT` float DEFAULT '1',
  `SUP_QUANT` float DEFAULT '0',
  `INV_QUANT` float DEFAULT '0',
  `UNITPRICE` float DEFAULT '0',
  `DISCOUNT` float DEFAULT '0',
  `ANALYSIS` int(11) DEFAULT '0',
  `LOCATION` int(11) DEFAULT '1',
  `SUPPLY_NOW` float DEFAULT '0',
  `INVOICE_NOW` float DEFAULT '0',
  `JOBCODE` varchar(15) DEFAULT NULL,
  `BATCHCODE` varchar(20) DEFAULT NULL,
  `SUBCODE` int(11) DEFAULT '0',
  `BRANCHNO` int(11) DEFAULT '0',
  `LAST_SUP` float DEFAULT '0',
  `LAST_INV` float DEFAULT '0',
  `TAXRATE` float DEFAULT NULL,
  `TAXRATE_NO` int(11) DEFAULT NULL,
  `LINETAX_OVERRIDE` float DEFAULT NULL,
  `LINETAX_OVERRIDDEN` char(1) DEFAULT NULL,
  `SERIALNO` varchar(50) DEFAULT NULL,
  `RELEASE_QUANT` float DEFAULT '-1',
  `BINCODE` varchar(12) DEFAULT NULL,
  `LINETOTAL` float DEFAULT NULL,
  `LSTATUS` int(11) DEFAULT '0',
  `LISTPRICE` float DEFAULT '0',
  `SOLINEID` int(11) DEFAULT '0',
  `CONTRACT_HDR` int(11) DEFAULT NULL,
  `LINKED_STOCKCODE` varchar(40) DEFAULT NULL,
  `LINKED_QTY` float DEFAULT '1',
  `BKORD_QUANT` float NOT NULL DEFAULT '0',
  `UNINV_QUANT` float DEFAULT NULL,
  `PICK_NOW` float NOT NULL DEFAULT '0',
  `PICKED_QUANT` float NOT NULL DEFAULT '0',
  `LAST_PICKED` float NOT NULL DEFAULT '0',
  `RELEASE_NOW` float NOT NULL DEFAULT '0',
  `LAST_RELEASED` float NOT NULL DEFAULT '0',
  `NARRATIVE_SEQNO` int(11) DEFAULT NULL,
  `PRICE_OVERRIDDEN` char(1) NOT NULL DEFAULT 'N',
  `KITCODE` varchar(23) DEFAULT NULL,
  `HDR_STATUS` int(11) NOT NULL DEFAULT '-1',
  `LINETYPE` int(11) NOT NULL DEFAULT '-1',
  `SUPPLIERNO` int(11) DEFAULT '0',
  `PURCHORDNO` int(11) DEFAULT '0',
  `BKORD_BATCHNO` int(11) DEFAULT '0',
  `KITSEQNO` int(11) NOT NULL DEFAULT '-1',
  `BOMTYPE` char(1) DEFAULT 'N',
  `SHOWLINE` char(1) DEFAULT 'Y',
  `LINKEDSTATUS` char(1) DEFAULT 'N',
  `BOMPRICING` char(1) DEFAULT 'N',
  `HIDDEN_SELL` float DEFAULT NULL,
  `CORRECTION_QUANT` float DEFAULT '0',
  `CORRECTED_QUANT` float DEFAULT NULL,
  `BSOLP_BATCHNO` int(11) DEFAULT '-1',
  `UNSUP_QUANT` float DEFAULT NULL,
  `CUSTORDERNO` varchar(20) DEFAULT NULL,
  `DUEDATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbSTAFF`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSTAFF` (
  `STAFFNO` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(30) DEFAULT NULL,
  `JOBTITLE` varchar(30) DEFAULT NULL,
  `EXTENSION` varchar(12) DEFAULT NULL,
  `PHONE` varchar(30) DEFAULT NULL,
  `HOMEPHONE` varchar(30) DEFAULT NULL,
  `ISACTIVE` char(1) DEFAULT NULL,
  `APP_PASSWORD` varchar(30) DEFAULT NULL,
  `MENU_NO` int(11) DEFAULT NULL,
  `AUTH_AMT` float DEFAULT NULL,
  `STOCK_AUTH_AMT` float DEFAULT NULL,
  `NON_STOCK_AUTH_AMT` float DEFAULT NULL,
  `SECURITYPROFILEID` int(11) NOT NULL DEFAULT '0',
  `USERPROFILEID` int(11) NOT NULL DEFAULT '0',
  `LOGINID` varchar(30) NOT NULL DEFAULT '',
  `PASSWORD_CHANGED` datetime NOT NULL,
  `LAST_BAD_LOGIN` datetime DEFAULT NULL,
  `BAD_LOGIN_COUNT` int(11) NOT NULL DEFAULT '0',
  `LAST_LOGIN` datetime DEFAULT NULL,
  `ACCOUNT_STATUS` int(11) NOT NULL DEFAULT '0',
  `EMAIL_ADDRESS` varchar(50) DEFAULT NULL,
  `DISCOUNTRATE` float NOT NULL DEFAULT '0',
  `PAYROLL_ID` varchar(15) DEFAULT NULL,
  `IS_SUPERVISOR` char(1) NOT NULL DEFAULT 'N',
  `NICKNAME` varchar(15) DEFAULT NULL,
  `ABSENT` char(1) NOT NULL DEFAULT 'N',
  `EMPLOYEE_CODE` int(11) NOT NULL DEFAULT '-1',
  `SMTP_SEQNO` int(11) DEFAULT '-1',
  `HAS_BUDGETS` char(1) DEFAULT 'N',
  `REPORTS_TO_STAFFNO` int(11) DEFAULT '-1',
  PRIMARY KEY (`STAFFNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbSTOCK_ITEMS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSTOCK_ITEMS` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `STOCKCODE` varchar(23) NOT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `STOCKGROUP` int(11) DEFAULT '0',
  `STATUS` char(1) DEFAULT 'L',
  `SELLPRICE1` float DEFAULT '0',
  `SELLPRICE2` float DEFAULT '0',
  `SELLPRICE4` float DEFAULT '0',
  `SELLPRICE5` float DEFAULT '0',
  `SELLPRICE6` float DEFAULT '0',
  `SELLPRICE7` float DEFAULT '0',
  `SELLPRICE8` float DEFAULT '0',
  `SELLPRICE9` float DEFAULT '0',
  `SELLPRICE10` float DEFAULT '0',
  `LATESTCOST` float DEFAULT '0',
  `AVECOST` float DEFAULT '0',
  `MINSTOCK` float DEFAULT '0',
  `MAXSTOCK` float DEFAULT '0',
  `SUPPLIERNO` int(11) DEFAULT '0',
  `MONTHUNITS` float DEFAULT '0',
  `YEARUNITS` float DEFAULT '0',
  `LASTYEARUNITS` float DEFAULT '0',
  `MONTHVALUE` float DEFAULT '0',
  `YEARVALUE` float DEFAULT '0',
  `LASTYEARVALUE` float DEFAULT '0',
  `BINCODE` varchar(12) DEFAULT NULL,
  `DISCOUNTLEVEL` int(11) DEFAULT '0',
  `DEFDAYS` int(11) DEFAULT '0',
  `BARCODE1` varchar(30) DEFAULT NULL,
  `BARCODE2` varchar(30) DEFAULT NULL,
  `BARCODE3` varchar(30) DEFAULT NULL,
  `LASTMONTHVALUE` float DEFAULT '0',
  `LASTMONTHUNITS` float DEFAULT '0',
  `SALES_GL_CODE` int(11) DEFAULT '0',
  `PURCH_GL_CODE` int(11) DEFAULT '0',
  `WEB_SHOW` char(1) DEFAULT 'N',
  `ISACTIVE` char(1) DEFAULT 'Y',
  `WEIGHT` float DEFAULT '0',
  `CUBIC` float DEFAULT '0',
  `ALERT` varchar(60) DEFAULT NULL,
  `NOTES` varchar(4096) DEFAULT NULL,
  `PQTY` float DEFAULT '1',
  `PACK` varchar(10) DEFAULT NULL,
  `HAS_SN` char(1) DEFAULT 'N',
  `STDCOST` float DEFAULT '0',
  `SUPPLIERNO2` int(11) DEFAULT NULL,
  `SUPPLIERNO3` int(11) DEFAULT NULL,
  `SALES_GLSUBCODE` int(11) DEFAULT '0',
  `PURCH_GLSUBCODE` int(11) DEFAULT '0',
  `BRANCHNO` int(11) DEFAULT '0',
  `SALESTAXRATE` int(11) DEFAULT '-1',
  `PURCHTAXRATE` int(11) DEFAULT '-1',
  `LAST_UPDATED` datetime DEFAULT NULL,
  `UPDATEITEM_CODE` varchar(23) DEFAULT NULL,
  `UPDATEITEM_QTY` float DEFAULT '0',
  `COS_GL_CODE` int(11) DEFAULT '0',
  `COS_GLSUBCODE` int(11) DEFAULT '0',
  `STOCKPRICEGROUP` int(11) DEFAULT '0',
  `SUPPLIERCOST` float NOT NULL DEFAULT '0',
  `ECONORDERQTY` float DEFAULT NULL,
  `LINKED_BILLCODE` varchar(23) DEFAULT NULL,
  `STOCK_CLASSIFICATION` int(11) NOT NULL DEFAULT '0',
  `STOCKGROUP2` int(11) DEFAULT '0',
  `TOTALSTOCK` float NOT NULL DEFAULT '0',
  `HAS_BN` char(1) DEFAULT 'N',
  `HAS_EXPIRY` char(1) NOT NULL DEFAULT 'N',
  `EXPIRY_DAYS` int(11) DEFAULT '1',
  `DUTY` float NOT NULL DEFAULT '0',
  `SERIALNO_TYPE` int(11) NOT NULL DEFAULT '0',
  `COSTTYPE` int(11) NOT NULL DEFAULT '0',
  `COSTGROUP` int(11) NOT NULL DEFAULT '0',
  `LABEL_QTY` int(11) NOT NULL DEFAULT '1',
  `IS_DISCOUNTABLE` char(1) NOT NULL DEFAULT 'Y',
  `RESTRICTED_ITEM` char(1) NOT NULL DEFAULT 'N',
  `NUMDECIMALS` int(11) NOT NULL DEFAULT '-1',
  `COGSMETHOD` int(11) NOT NULL DEFAULT '0',
  `DEFAULTWARRANTYNO` int(11) NOT NULL DEFAULT '-1',
  `DIMENSIONS` int(11) NOT NULL DEFAULT '0',
  `VARIABLECOST` char(1) NOT NULL DEFAULT 'N',
  `LONG_DESCRIPTION` varchar(255) DEFAULT NULL,
  `PRODUCT_DETAILS` varchar(255) DEFAULT NULL,
  `FEATURE_SPECS` varchar(255) DEFAULT NULL,
  `SUB_DESCRIPTION` varchar(255) DEFAULT NULL,
  `STOCK_ITEM_IMAGE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `STOCKCODE` (`STOCKCODE`),
  FULLTEXT KEY `DESCRIPTION` (`DESCRIPTION`),
  FULLTEXT KEY `LONG_DESCRIPTION` (`LONG_DESCRIPTION`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbSTOCK_ITEMS_CATEGORIES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSTOCK_ITEMS_CATEGORIES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_TYPE` varchar(24) NOT NULL COMMENT 'The type of  category this item belongs to. FK to #__menu_types.menutype',
  `TITLE` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `ALIAS` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `NOTE` varchar(255) NOT NULL DEFAULT '',
  `PATH` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `LINK` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `TYPE` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `PUBLISHED` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `PARENT_ID` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `LEVEL` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `ORDERING` int(11) NOT NULL DEFAULT '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `APPROVED` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `BROWSERNAV` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `ACCESS` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `IMG` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `PARAMS` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `HOME` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `LANGUAGE` char(7) NOT NULL DEFAULT '',
  `CLIENT_ID` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `idx_client_id_parent_id_alias` (`CLIENT_ID`,`PARENT_ID`,`ALIAS`),
  KEY `idx_menutype` (`CATEGORY_TYPE`),
  KEY `idx_alias` (`ALIAS`),
  KEY `idx_path` (`PATH`(333)),
  KEY `idx_LANGUAGE` (`LANGUAGE`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbSTOCK_ITEMS_CATEGORIES` VALUES (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,0,0,'',0,'',0,'*',0),(2,'menu','com_banners','Banners','','Banners','index.php?option=com_banners','component',0,1,1,0,0,0,0,'class:banners',0,'',0,'*',1),(3,'menu','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',0,2,2,0,0,0,0,'class:banners',0,'',0,'*',1);
DROP TABLE IF EXISTS `TbSTOCK_WEB`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSTOCK_WEB` (
  `STOCKCODE` char(23) NOT NULL,
  `SALES_HTML` varchar(4096) DEFAULT NULL,
  `PICTURE_URL` varchar(80) DEFAULT NULL,
  `NEW_ARRIVALS` char(1) NOT NULL DEFAULT 'N',
  `FREIGHT_FREE` char(1) NOT NULL DEFAULT 'N',
  `PARAMS` tinytext NOT NULL,
  `ATTRIBUTES` text NOT NULL,
  PRIMARY KEY (`STOCKCODE`),
  FULLTEXT KEY `PARAMS` (`PARAMS`),
  FULLTEXT KEY `ATTRIBUTES` (`ATTRIBUTES`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TbSessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbSessions` (
  `id` varchar(200) CHARACTER SET utf8 NOT NULL,
  `modified` int(11) NOT NULL,
  `lifetime` int(20) DEFAULT NULL,
  `data` mediumtext CHARACTER SET utf8 NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `clientid` tinyint(3) NOT NULL,
  `guest` tinyint(4) DEFAULT NULL,
  `username` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `lifetime` (`lifetime`),
  KEY `whosonline` (`guest`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbSessions` VALUES ('29gr36f5h9kqp5j64cq63j9me3',1325316214,1440,'{\"id\":\"1\",\"contactname\":\"David Oabile\",\"company\":\"Infosyspro\",\"condition_id\":\"\",\"roleid\":\"6\",\"dob\":\"2010-04-12\",\"email\":\"doabile@infosyspro.com.au\",\"street\":\"23 burr crt\",\"suburb\":\"Pacific\",\"postcode\":\"4521\",\"state\":\"QLD\",\"country\":\"Botswana\",\"phone\":\"07558224562\",\"mobile\":\"042154254254\",\"fax\":\"\",\"how\":null,\"why\":null,\"pref1\":null,\"pref2\":null,\"pref3\":null,\"join_date\":\"0000-00-00\",\"username\":\"davido\",\"hash\":null,\"role\":null,\"status\":\"1\",\"is_wholesaler\":\"1\",\"clientId\":0,\"guest\":0}',1,0,0,'davido');
DROP TABLE IF EXISTS `TbStickies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbStickies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbStickies` VALUES (1,'Special!','<h1>This week we have a special, half price on delicious oranges!</h1><div>Only for our special customers!</div><div>Use the code: Joomla! when ordering</div><p><em>This module can only be seen by people in the customers group or higher.</em></p>',1,'position-12',1,'mod_custom',4,1,'{\"prepare_content\":\"1\",\"layout\":\"\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}',0,'*'),(2,'Login','',1,'login',1,'mod_login',1,1,'',1,'*');
DROP TABLE IF EXISTS `TbUsergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbUsergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_usergroup_title_lookup` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbUsergroups` VALUES (1,'Public'),(2,'Registered'),(3,'Author'),(4,'Editor'),(5,'Publisher'),(6,'Manager'),(7,'Administrator'),(8,'Super Users'),(12,'Customer Group (Example)'),(10,'Shop Suppliers (Example)');
DROP TABLE IF EXISTS `TbUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `condition_id` varchar(100) DEFAULT '',
  `roleid` int(10) DEFAULT NULL,
  `dob` date NOT NULL DEFAULT '0000-00-00',
  `email` varchar(100) DEFAULT NULL,
  `street` varchar(100) NOT NULL DEFAULT '',
  `suburb` varchar(50) NOT NULL DEFAULT '',
  `postcode` varchar(12) NOT NULL DEFAULT '',
  `state` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(25) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `how` text,
  `why` text,
  `pref1` int(11) DEFAULT NULL,
  `pref2` int(11) DEFAULT NULL,
  `pref3` int(11) DEFAULT NULL,
  `join_date` date NOT NULL DEFAULT '0000-00-00',
  `username` varchar(25) DEFAULT 'none',
  `password` varchar(20) DEFAULT NULL,
  `hash` varchar(254) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `is_wholesaler` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbUsers` VALUES (1,'David Oabile','Infosyspro','',6,'2010-04-12','doabile@infosyspro.com.au','23 burr crt','Pacific','4521','QLD','Botswana','07558224562','042154254254','',NULL,NULL,NULL,NULL,NULL,'0000-00-00','davido','dailer00',NULL,NULL,'1',1);
DROP TABLE IF EXISTS `TbVersion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TbVersion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `number` (`number`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `TbVersion` VALUES (1,'1.0');
DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `ID` int(11) NOT NULL DEFAULT '0',
  `productID` varchar(20) NOT NULL DEFAULT '0',
  `ProductName` text NOT NULL,
  `Description` mediumtext NOT NULL,
  `Ingredients` mediumtext NOT NULL,
  `Price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `SpecialOffer` text NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`productID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `admin` VALUES (1,'white&green','White & Green','Finally,a MINT You always wanted : Fresh,Strong but Delicate and Long lasting !!And remember,no ZIZI,no kiss...Have fun and choose your favorite colour...Golf or ski ?','Natural Sugar Cane,Glucose,natural mint flavour,Menthol, colorant for the Green Ball.','1.30','18 boxes for 20$A + Transport           ',10),(10,'black&white','Black & White','This is really BLACK & WHITE !!       A Luscious LICORICE with a *SPARK* of refreshing WHITE MINT..            Ideal for..smokers & ex smokers !!!    No ZIZI,no Kiss...','Sugar Cane,Glucose Syrup,Natural extract of Licorice,Menthol,natural color','1.30','18 boxes for 20$ + Transport      ',0),(2,'red&white','Red & White','The ideal for MINT addicts..Bravery will enflam your partner as well..Have fun...Red Hot... ','Sugar Cane,Glucose Syrup,Extra Strong Peppermint extract,Menthol and Red colorant for The Red Balls...','1.30','!8 boxes for 20$ A. + Transportt         ',200),(3,'Orange','Zazi Orange','The Natural Taste of Seville Oranges combined with the smoothness of Gum Arabica,to give You a pleasurable SUGARFREE treat...And remember : ZAZI Orange is SUGAR FREE, LOW CARB. LOW GI., GLUTEN FREE as well as DAIRY FREE !!!','Natural Gum Arabica,maltitol,Flavours,natural colorant','1.80','18 packets for $30.00 +transport       ',12),(4,'Mango','Zazi Mango','The most delicate Flavour of this delicious Exotic Fruit..A dream of holydays in those far,far away places !Bite and you will remember that juicy smooth Taste...Gum Arabica will give a long lasting support to the flavour..A complete Natural Taste. SUGAR FREE, GLUTEN FREE,DAIRY FREE, LOW CARB and LOW GI. The usual ZAZI perfection..','Gum Arabica,Maltitol,Mango flavour','1.80',' 18 packets for 30$ + Transport',10),(5,'Strawberry','Zazi Strawberry','Strawberry..What can we add ? A Real Fresh Taste ..Lots of Pleasure with this candy made of  Natural Gum Arabica : SUGAR FREE, GLUTEN FREE, LOW CARB., LOW G.I. and DAIRY FREE..! Enjoy ZAZI Strawberry Pastilles.','Gum Arabica,maltitol.fruit juice,natural color','1.80','18 packets for 30$ + Transport ',10),(6,'Blackcurrant','Zazi Black Currant','So Juicy,and that very special Natural Taste!ZAZI creation made of Gum Arabica with Real Fruit Juice will convince you that SUGARFREE is better than confectioneries made of sugar...ZAZI is also GLUTEN Free, LOW CARB, LOW GI. and DAIRY FREE !!!','Gum Arabica,Maltitol,Blackcurrant Fruit Juice','1.80','18 packets for 30$ + Transport   ',0),(7,'rewards','Rewards and Competitions','When you purchase from our site the minimum requirement,you will be entered into the competitions automatically without the obligation of sending the 4 packets.. Otherwise                           send 4 packets of any ZIZI MINTS and you will be participating in our \"Argentinian\" competitions.Every 2 months a lucky winner will get one year FREE supply of ZIZI MINTS assorted Flavours.. ','Every 6 months,another lucky winner will receive 1000$ cash  ! Then our SUPER HERO,once a year, will get a trip for 2, to Argentina, BUSINESS CLASS and Hotels paid for a stay of 10 days and will be invited to visit the factory and meet some of \"The Extraordinary People\" who make ZIZI!!!! If you are from another part of the world and not living in Australia we will endeavour-your location permitting-to fly you in Australia, Business Class and organise FREE your accomodations for 15 days.In case of great difficulties or impossibilities an amount of 15000$ will be sent to you : The choice being entirely at the discretion of ZIZI corporation.. ','1.30','18 boxes for 20$+ transport         ',0),(8,'zazirewards','Rewards and Competitions','When purchasing from our site the minimum requirement you will,automatically,be entered into our competitions without the obligation to send 4 packets of ZIZI products. Otherwise send 4 packets of any ZAZI SUGARFREE candies and you will be participating in our \"ITALIAN\"competitions : Every 2 months,a lucky winner will get one year free supply of ZAZI SUGARFREE candies assorted flavours.','Every 6 months,another lucky winner will receive 1000$ cash! Then our \"SUPER HERO\",once a year,will receive a trip for 2 FIRST class to VENICE,Hotel paid for 5 days and 1000$ CASH to cover 5 nights Hotels of your OWN choice of adventure in ITALY!!!A total of 10 days! You will be as well meeting \"The Extraordinary People\" who make ZAZI SUGARFREE candies. If you live somewhere else than Australia,we will organise your travel to our Extraordinary Australian continent, business class and 15 days accomodations FREE.If,due to you location,it is extremely difficult,we will send you a cheque for 15000$ : That choice is entirely to the discretion of ZIZI corporation....','1.80',' 18 boxes for 30$ + Transport            ',0),(9,'music','Show us your talent','Produce an Original (must be your own) Musical Creation for ZIZI and or ZAZI. If your Music is accepted as \"ZIZI MUSIC\" or \"ZAZI MUSIC\", You will be rewarded with a cash price of $1000 and a supply of ZIZI or ZAZI products for 3 years. The winner will also receive a certificate of belonging to \"The Extraordinary People\".','1. All productions must be your own.<br>\r\n2. If your production is deemed to be plagiarized from others, ZIZI corporation  will not accept any responsibility  whatsoever<br>\r\n3. The production will automatically become the property of ZIZI corporation including all copyright  protected by the international Laws<br>\r\n4. Upon submission you will be automatically registered to our ZIZI CLUB<br>\r\n5. Your production must be less than 1 MB<br>\r\n6. No indecent or swear words\r\n','0.00','           ',0),(11,'Poems & Slogans','','Produce an original (must be your own) Slogan and or Poem Schemes for ZIZI and or ZAZI. If your Poem/slogan is accepted as \"ZIZI Poem\" or \"ZAZI Poem\" or slogans, you will be rewarded with a cash price of $1000 and a supply of ZIZI or ZAZI products for 3 years. The winner will also receive a certificate of belonging to \" The Extraordinary People\".','1. All productions must be your own.<br>\r\n2. If your production is deemed to be plagiarized from others Zizi or Zazi will not take responsibility  whatsoever<br>\r\n3. The production will automatically become the property of Zizi and or Zazi including all copyright laws<br>\r\n4. Upon submission you will be automatically registered to our ZIZI CLUB<br>\r\n5. Your production must be less than 1 MB<br>\r\n6. No indecent or swear words','0.00','     ',0),(12,'Licorice','Zazi Licorice','Nuances of Mint in a delightful mix of Maltitol Syrup with Pure Licorice Essence.Very refreshing..A SUGARFREE,DAIRY FREE,GLUTEN FREE,LOW CARB,LOW G.I. Life Creation from ZAZI..','Natural Gum Arabica,Maltitol Syrup,Natural Mint and Natural Licorice Essence','1.80',' 18 packets for 30.00A$ + Transport ',0);
DROP TABLE IF EXISTS `basket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `products_id` mediumint(9) NOT NULL,
  `quantity` int(2) NOT NULL,
  `price_exgst` decimal(15,2) NOT NULL,
  `final_price` decimal(15,2) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_id` (`customers_id`),
  KEY `products_id` (`products_id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `basket` VALUES (1,100000,4,1,'1.40','1.40','0000-00-00 00:00:00'),(2,100000,3,1,'1.40','1.40','0000-00-00 00:00:00'),(3,100000,2,1,'1.40','1.40','0000-00-00 00:00:00'),(4,100000,2,3,'1.40','1.40','0000-00-00 00:00:00'),(84,1,5,4,'24.00','7.20','2010-11-28 01:09:45'),(86,1,3,1,'1.40','1.40','2010-11-28 01:08:53'),(87,1,2,1,'1.27','1.40','2010-11-28 01:11:58'),(88,1,1,2,'1.27','2.80','2010-11-28 01:12:24');
DROP TABLE IF EXISTS `counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counter` (
  `page` varchar(50) DEFAULT NULL,
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `counter` VALUES ('/index.php',14512),('/zizimusic.php',202),('/zizipoems.php',108);
DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `CustID` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(20) NOT NULL DEFAULT '',
  `Lastname` varchar(20) NOT NULL DEFAULT '',
  `Address` varchar(30) NOT NULL DEFAULT '',
  `State` varchar(5) NOT NULL DEFAULT '',
  `City` varchar(30) NOT NULL DEFAULT '',
  `Postcode` varchar(4) NOT NULL DEFAULT '',
  `Postaladdress` varchar(30) DEFAULT NULL,
  `Hometel` varchar(10) NOT NULL DEFAULT '',
  `Businesstel` varchar(10) NOT NULL DEFAULT '',
  `Mobile` varchar(10) DEFAULT NULL,
  `Fax` varchar(10) DEFAULT NULL,
  `Custemail` varchar(30) NOT NULL DEFAULT '',
  `quantity` int(10) NOT NULL DEFAULT '0',
  `productname` varchar(50) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '',
  `Paymethod` varchar(20) NOT NULL DEFAULT '',
  `Credittype` varchar(20) DEFAULT NULL,
  `Cardholdername` varchar(30) DEFAULT NULL,
  `Cardnumber` varchar(16) DEFAULT NULL,
  `Expirydate` varchar(10) DEFAULT NULL,
  `lastdigits` char(3) DEFAULT NULL,
  `Date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`CustID`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `feed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `caller_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `position` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `caller_name` (`caller_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `feed` VALUES (1,'Upcoming Products','layout.default','All New products will be advertised here and if you are a member you may be eligible for tasting new products before they are published.','right');
DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `name` varchar(100) NOT NULL DEFAULT '',
  `Description` varchar(50) NOT NULL DEFAULT '',
  `links` varchar(100) NOT NULL DEFAULT '',
  `productname` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `images` VALUES ('boughtorange.jpg','Orange','zazi_orange.php','orange'),('boughtmango.jpg','Mango','zazi_mango.php','mango'),('boughtstrawberry.jpg','Strawberry','zazi_strawberry.php','strawberry'),('boughtcurrant.jpg','Currant','zazi_black_currant.php','blackcurrant'),('boughtblack.jpg','White','sugarless_black_white.php','black&white'),('boughtgreen.jpg','Green','sugarless.php','white&green'),('boughtred.jpg','Red','sugarless_red_white.php','red&white'),('boughtlicorice.jpg','Licorice','zazi_licorice.php','Licorice');
DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Companyname` varchar(100) DEFAULT NULL,
  `contactname` varchar(100) NOT NULL DEFAULT '',
  `tel` varchar(10) NOT NULL DEFAULT '',
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `Address` text NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `active` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `member` VALUES (1,'my company name','David Oabile','0749273633','0749373644','davido@cyberoz.com.au','12 William St Rockhampton 4700 QLD','davido','dailer','2006-10-11','Yes'),(2,'Tinsonax (NSW) Pty Ltd','John Thumpkins','02 9722 91','02 9792 31','john@tinsonax.com.au','Unit 3, 4 Brunker Road\r\nChullora\r\nNSW   2190 ','John','tom','2006-11-29','No'),(3,'my company name','jacques vasseur','0427 -1916','area code','tsc@connexus.net.au','638 musgrave     robertson \r\nqueensland \r\n4109australia ','talbot','chien','2006-10-25','Mem'),(4,'Sugarless co','jacques vasseur','0427-19168','03-9387706','tsc@connexux.net.au','19-21 gale st \r\neast brunswick \r\nvictoria.3057\r\naustralia ','sugarless','zizi','2006-10-25','No'),(5,'sugarlessco','aurel','0393881971','area code','info@sugarlessco.com','Number  Street \r\nCity Country \r\nState Postcode ','aurel','123456','2007-04-26','Mem'),(6,'Empress Creative','Francis Samson','0883901249','083901011','fsamson@hngs.com.au','Delamere\r\nAshton SA 5137\r\nSA5137','Francis','open','2007-11-15','Mem'),(7,'Lolly Castle','Yanni Gao','02 8021385','02 8021385','lollycastle@live.com','16/12 Essex St\r\nEpping \r\nNSW 2121 ','yanni gao','276419','2009-06-13','No'),(8,'sugarlessco pty ltd','jacques aubry','03-9387751','03 9387706','sugarlessco@cyberoz.com.au','19-21 gale street \r\neast brunswick \r\nvic. 3057','hopenostop','tamuslechat','2009-08-25','No');
DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `condition_id` varchar(100) DEFAULT '',
  `groupid` varchar(100) DEFAULT '',
  `dob` date NOT NULL DEFAULT '0000-00-00',
  `email` varchar(100) DEFAULT NULL,
  `street` varchar(100) NOT NULL DEFAULT '',
  `suburb` varchar(50) NOT NULL DEFAULT '',
  `postcode` varchar(12) NOT NULL DEFAULT '',
  `state` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(25) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `mobile` varchar(14) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `how` text,
  `why` text,
  `pref1` int(11) DEFAULT NULL,
  `pref2` int(11) DEFAULT NULL,
  `pref3` int(11) DEFAULT NULL,
  `join_date` date NOT NULL DEFAULT '0000-00-00',
  `username` varchar(25) DEFAULT 'none',
  `password` varchar(20) DEFAULT NULL,
  `hash` varchar(254) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `is_wholesaler` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_wholesaler` (`is_wholesaler`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `members` VALUES (1,'David Oabile','Infosyspro','','Admin','2010-04-12','doabile@infosyspro.com.au','23 burr crt','Pacific','4521','QLD','Botswana','07558224562','042154254254','',NULL,NULL,NULL,NULL,NULL,'0000-00-00','davido','dailer00',NULL,NULL,'1',1);
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Productname` varchar(100) NOT NULL DEFAULT '',
  `UserIP` varchar(20) NOT NULL DEFAULT '',
  `orderdate` date NOT NULL DEFAULT '0000-00-00',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` varchar(10) NOT NULL DEFAULT '0.00',
  `subtotal` varchar(10) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`OrderID`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `orders` VALUES (138,'white&green','220.157.89.204','2008-08-06',1,'1.30','1.3'),(134,'orange','203.122.136.54','2008-02-22',1,'1.80','1.8'),(142,'white&green','122.107.247.152','2008-10-06',1,'1.30','1.3'),(136,'strawberry','203.122.136.54','2008-05-06',1,'1.80','1.8'),(135,'mango','203.122.136.54','2008-02-22',1,'1.80','1.8'),(127,'white&green','202.83.93.165','2007-05-17',1,'1.30','1.3'),(137,'mango','202.144.162.86','2008-08-06',1,'1.80','1.8'),(105,'black&white','220.157.87.1','2006-10-07',61,'1.30','79.8'),(125,'white&green','59.167.83.25','2007-05-01',1,'1.30','1.3'),(104,'red&white','220.157.87.1','2006-10-07',13,'1.30','17.4'),(103,'blackcurrant','220.157.87.1','2006-10-07',14,'1.80','23.2'),(102,'mango','220.157.87.1','2006-10-07',7,'1.80','10.6'),(101,'strawberry','220.157.87.1','2006-10-07',10,'1.80','16'),(99,'orange','220.157.87.1','2006-10-07',6,'1.80','8.8'),(124,'white&green','203.214.100.157','2007-04-26',1,'1.30','1.3'),(100,'white&green','220.157.87.1','2006-10-07',8,'1.30','10.9'),(123,'black&white','203.214.100.157','2007-04-26',1,'1.30','1.3'),(139,'blackcurrant','220.157.89.204','2008-08-06',1,'1.80','1.8'),(143,'white&green','114.73.12.11','2008-10-06',1,'1.30','1.3'),(144,'white&green','202.137.164.111','2009-09-14',1,'1.30','1.3'),(145,'white&green','122.105.187.173','2009-09-23',1,'1.30','1.3'),(146,'orange','122.105.187.173','2009-09-23',1,'1.80','1.8'),(147,'red&white','58.163.52.198','2009-10-23',2,'1.30','2.6'),(148,'white&green','150.101.113.129','2009-11-17',1,'1.30','1.3'),(149,'mango','139.130.234.2','2010-01-23',1,'1.80','1.8'),(150,'white&green','139.130.234.2','2010-01-23',1,'1.30','1.3');
DROP TABLE IF EXISTS `orders_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_orders` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_status` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `pending_reason` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `payment_date` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `subtotal` double NOT NULL,
  `Handling` double NOT NULL,
  `gross` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `invoice` varchar(30) COLLATE utf8_bin NOT NULL,
  `payer_email` varchar(127) COLLATE utf8_bin DEFAULT NULL,
  `protection_eligibility` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `cust_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `items` longtext COLLATE utf8_bin,
  `creation_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `store_status` varchar(15) COLLATE utf8_bin DEFAULT 'PENDING',
  `locked_by` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Names` varchar(150) COLLATE utf8_bin NOT NULL,
  `Address` tinyblob NOT NULL,
  `mobile` varchar(12) COLLATE utf8_bin NOT NULL,
  `phone` varchar(12) COLLATE utf8_bin NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_state` varchar(10) COLLATE utf8_bin NOT NULL,
  `type` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'Web',
  PRIMARY KEY (`id`),
  KEY `store_status` (`store_status`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `orders_orders` VALUES (1,'Completed','','20:33:28 Aug 29, 2009 ',91.22,35,96.84,5.62,'AUD','D0908303335R','denisereichle@bigpond.com','Ineligible','1','a:16:{i:0;a:6:{s:11:\"products_id\";i:10;s:3:\"ref\";s:3:\"157\";s:7:\"flavour\";N;s:5:\"title\";s:17:\"ZAZI GUM  1kg BAG\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:5:\"32.00\";}i:1;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:2;a:6:{s:11:\"products_id\";i:3;s:3:\"ref\";s:3:\"143\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LICORICE 1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:3;a:6:{s:11:\"products_id\";i:8;s:3:\"ref\";s:3:\"154\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZAZI 3-FRUITS.1x24\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.80\";}i:4;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:5;a:6:{s:11:\"products_id\";i:9;s:3:\"ref\";s:3:\"155\";s:7:\"flavour\";N;s:5:\"title\";s:19:\"ZAZI MENTHOL EUCALY\";s:8:\"quantity\";i:8;s:11:\"final_price\";s:4:\"1.80\";}i:6;a:6:{s:11:\"products_id\";i:9;s:3:\"ref\";s:3:\"155\";s:7:\"flavour\";N;s:5:\"title\";s:19:\"ZAZI MENTHOL EUCALY\";s:8:\"quantity\";i:8;s:11:\"final_price\";s:4:\"1.80\";}i:7;a:6:{s:11:\"products_id\";i:9;s:3:\"ref\";s:3:\"155\";s:7:\"flavour\";N;s:5:\"title\";s:19:\"ZAZI MENTHOL EUCALY\";s:8:\"quantity\";i:8;s:11:\"final_price\";s:4:\"1.80\";}i:8;a:6:{s:11:\"products_id\";i:10;s:3:\"ref\";s:3:\"157\";s:7:\"flavour\";N;s:5:\"title\";s:17:\"ZAZI GUM  1kg BAG\";s:8:\"quantity\";i:3;s:11:\"final_price\";s:5:\"32.00\";}i:9;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:10;a:6:{s:11:\"products_id\";i:1;s:3:\"ref\";s:3:\"141\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI PEPP.25g 1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:11;a:6:{s:11:\"products_id\";i:1;s:3:\"ref\";s:3:\"141\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI PEPP.25g 1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:12;a:6:{s:11:\"products_id\";i:1;s:3:\"ref\";s:3:\"141\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI PEPP.25g 1x36\";s:8:\"quantity\";i:9;s:11:\"final_price\";s:4:\"1.40\";}i:13;a:6:{s:11:\"products_id\";i:8;s:3:\"ref\";s:3:\"154\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZAZI 3-FRUITS.1x24\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.80\";}i:14;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:15;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}}','2009-08-29 13:26:02','Processing','storeadmin','Denise Reichle','<br><b> Name :</b> Denise Reichle<br><b> Contacts :</b> 0746951618<br /><b> Mobile : </b>0429776618<br><b> Email :</b> denisereichle@bigpond.com<br><b> Address :</b> 8 Golf Club Rd<br> QLD  ,Millmerran, Australia, 4357','0429776618','0746951618','2009-09-09 09:50:25','QLD','Web'),(6,'Completed','','18:12:15 May 15, 2010 ',10.32,0,12.34,2.02,'USD','D1005161636O','','','1','a:16:{i:0;a:6:{s:11:\"products_id\";i:10;s:3:\"ref\";s:3:\"157\";s:7:\"flavour\";N;s:5:\"title\";s:17:\"ZAZI GUM  1kg BAG\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:5:\"32.00\";}i:1;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:2;a:6:{s:11:\"products_id\";i:3;s:3:\"ref\";s:3:\"143\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LICORICE 1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:3;a:6:{s:11:\"products_id\";i:8;s:3:\"ref\";s:3:\"154\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZAZI 3-FRUITS.1x24\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.80\";}i:4;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:5;a:6:{s:11:\"products_id\";i:9;s:3:\"ref\";s:3:\"155\";s:7:\"flavour\";N;s:5:\"title\";s:19:\"ZAZI MENTHOL EUCALY\";s:8:\"quantity\";i:8;s:11:\"final_price\";s:4:\"1.80\";}i:6;a:6:{s:11:\"products_id\";i:9;s:3:\"ref\";s:3:\"155\";s:7:\"flavour\";N;s:5:\"title\";s:19:\"ZAZI MENTHOL EUCALY\";s:8:\"quantity\";i:8;s:11:\"final_price\";s:4:\"1.80\";}i:7;a:6:{s:11:\"products_id\";i:9;s:3:\"ref\";s:3:\"155\";s:7:\"flavour\";N;s:5:\"title\";s:19:\"ZAZI MENTHOL EUCALY\";s:8:\"quantity\";i:8;s:11:\"final_price\";s:4:\"1.80\";}i:8;a:6:{s:11:\"products_id\";i:10;s:3:\"ref\";s:3:\"157\";s:7:\"flavour\";N;s:5:\"title\";s:17:\"ZAZI GUM  1kg BAG\";s:8:\"quantity\";i:3;s:11:\"final_price\";s:5:\"32.00\";}i:9;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:10;a:6:{s:11:\"products_id\";i:1;s:3:\"ref\";s:3:\"141\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI PEPP.25g 1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:11;a:6:{s:11:\"products_id\";i:1;s:3:\"ref\";s:3:\"141\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI PEPP.25g 1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:12;a:6:{s:11:\"products_id\";i:1;s:3:\"ref\";s:3:\"141\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI PEPP.25g 1x36\";s:8:\"quantity\";i:9;s:11:\"final_price\";s:4:\"1.40\";}i:13;a:6:{s:11:\"products_id\";i:8;s:3:\"ref\";s:3:\"154\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZAZI 3-FRUITS.1x24\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.80\";}i:14;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}i:15;a:6:{s:11:\"products_id\";i:4;s:3:\"ref\";s:3:\"144\";s:7:\"flavour\";N;s:5:\"title\";s:18:\"ZIZI LIC/MINT.1x36\";s:8:\"quantity\";i:1;s:11:\"final_price\";s:4:\"1.40\";}}','2010-05-15 00:00:00','Pending','','David Oabile','<br><b> Name :</b> David Oabile<br><b> Contacts :</b> 07558224562<br /><b> Mobile : </b>042154254254<br><b> Email :</b> doabile@infosyspro.com.au<br><b> Address :</b> 23 burr crt<br>   ,Pacific, Botswana,\n                    4521','042154254254','07558224562','2010-05-15 00:00:00','QLD','Web');
DROP TABLE IF EXISTS `process_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` varchar(20) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_process_orders_item_id` (`item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2862 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `prodcat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT NULL,
  `descr` text,
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `prodcat` VALUES (15,'Zizi Products',NULL,'Zizi Mints Products','1'),(16,'Zazi Products',NULL,'Zazi Products','1');
DROP TABLE IF EXISTS `prodcat_prodcat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodcat_prodcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT NULL,
  `descr` text,
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `prodcat_prodcat` VALUES (15,'Zizi Products',NULL,'Zizi Mints Products','1'),(16,'Zazi Products',NULL,'Zazi Products','1');
DROP TABLE IF EXISTS `product_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `prodcat` varchar(255) NOT NULL DEFAULT '',
  `flavour` varchar(100) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `boxcost_exgst` float DEFAULT NULL,
  `boxcost_gst` varchar(100) DEFAULT NULL,
  `unitcost_exgst` varchar(100) DEFAULT NULL,
  `retail_price` float DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `ingredients` text,
  `energy` varchar(100) DEFAULT NULL,
  `protein` varchar(100) DEFAULT NULL,
  `fat` varchar(100) DEFAULT NULL,
  `sat_fat` varchar(100) DEFAULT NULL,
  `trans_fat` varchar(100) DEFAULT NULL,
  `carb` varchar(100) DEFAULT NULL,
  `sugars` varchar(100) DEFAULT NULL,
  `lactitol` varchar(100) DEFAULT NULL,
  `isomalt` varchar(100) DEFAULT NULL,
  `mannitol` varchar(100) DEFAULT NULL,
  `maltitol` varchar(100) DEFAULT NULL,
  `polydextrose` varchar(100) DEFAULT NULL,
  `sorbitol` varchar(100) DEFAULT NULL,
  `fibre` varchar(100) DEFAULT NULL,
  `inulin` varchar(100) DEFAULT NULL,
  `gum` varchar(100) DEFAULT NULL,
  `sodium` varchar(100) DEFAULT NULL,
  `potassium` varchar(100) DEFAULT NULL,
  `ethical` text,
  `descr` text,
  `photo` varchar(255) DEFAULT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `flavour` (`flavour`),
  KEY `prodcat` (`prodcat`),
  KEY `ref` (`ref`),
  KEY `reserved` (`reserved`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM AUTO_INCREMENT=369 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `product_product` VALUES (341,'141','ZIZI PEPPERMINT (GREEN & WHITE) 25g (36/Box)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300141',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI PEPP.25g 1x36',NULL,'1','0'),(342,'142','ZIZI HOT MINT  FLAVOUR. 25g  (36/Box)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300142',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI HOT MINT 1x36',NULL,'1','0'),(343,'143','ZIZI LICORICE FLAV.(BLACK & WHITE) 25g (36/Box)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300143',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI LICORICE 1x36',NULL,'1','0'),(344,'144','ZIZI LICORICE & MINT FLAV. 25g (36/BOX)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300144',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI LIC/MINT.1x36',NULL,'1','0'),(345,'151','ZAZI BLACKCURRANT FLAV. 25g (24/Box)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300151',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI B/CURRANT.1x24',NULL,'1','0'),(346,'152','ZAZI ORANGE FLAVOUR 25g (24/BOX)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300152',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI ORANGE 1x24',NULL,'1','0'),(347,'153','ZAZI MANGO FLAVOUR 25g (24/BOX)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300153',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI MANGO FL. 1x24',NULL,'1','0'),(348,'154','ZAZI 3-FRUIT FLAVOURS 25g (24/BOX)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300154',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI 3-FRUITS.1x24',NULL,'1','0'),(349,'155','ZAZI MENTHOL EUCALYPTUS XTRA-STRONG 25g.(24/Box)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300155',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI MENTHOL EUCALY',NULL,'1','0'),(350,'157','ZAZI SUGARFREE GUM 1kg BAG BULK','16',NULL,'1',18,'19.8','18',32,'?',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI GUM  1kg BAG',NULL,'1','0');
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL,
  `prodcat` varchar(255) NOT NULL DEFAULT '',
  `flavour` varchar(100) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `boxcost_exgst` float DEFAULT NULL,
  `boxcost_gst` varchar(100) DEFAULT NULL,
  `unitcost_exgst` varchar(100) DEFAULT NULL,
  `retail_price` float DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `tun` varchar(100) NOT NULL,
  `ingredients` text,
  `energy` varchar(100) DEFAULT NULL,
  `protein` varchar(100) DEFAULT NULL,
  `fat` varchar(100) DEFAULT NULL,
  `sat_fat` varchar(100) DEFAULT NULL,
  `trans_fat` varchar(100) DEFAULT NULL,
  `carb` varchar(100) DEFAULT NULL,
  `sugars` varchar(100) DEFAULT NULL,
  `lactitol` varchar(100) DEFAULT NULL,
  `isomalt` varchar(100) DEFAULT NULL,
  `mannitol` varchar(100) DEFAULT NULL,
  `maltitol` varchar(100) DEFAULT NULL,
  `polydextrose` varchar(100) DEFAULT NULL,
  `sorbitol` varchar(100) DEFAULT NULL,
  `fibre` varchar(100) DEFAULT NULL,
  `inulin` varchar(100) DEFAULT NULL,
  `gum` varchar(100) DEFAULT NULL,
  `sodium` varchar(100) DEFAULT NULL,
  `potassium` varchar(100) DEFAULT NULL,
  `ethical` text,
  `title` text,
  `photo` varchar(255) DEFAULT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `reserved` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `title` (`description`),
  KEY `flavour` (`flavour`),
  KEY `prodcat` (`prodcat`),
  KEY `ref` (`ref`),
  KEY `reserved` (`reserved`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `products` VALUES (1,'141','ZIZI PEPPERMINT (GREEN & WHITE) 25g (36/Box)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300141','931264300143',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI PEPP.25g 1x36','greenandwhite.jpg','1','0'),(2,'142','ZIZI HOT MINT  FLAVOUR. 25g  (36/Box)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300142','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI HOT MINT 1x36','redandwhite.jpg','1','0'),(3,'143','ZIZI LICORICE FLAV.(BLACK & WHITE) 25g (36/Box)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300143','',NULL,'4','45','454','45','454','454','454','454','454','454','w4','w4w','wewe','wewe','wew','wew','wew','wew','no thong yet ','ZIZI LICORICE 1x36','blackandwhite.jpg','1','0'),(4,'144','ZIZI LICORICE & MINT FLAV. 25g (36/BOX)','15',NULL,'36',34.2,'37.62','0.95',1.4,'931264300144','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZIZI LIC/MINT.1x36',NULL,'1','0'),(5,'151','ZAZI BLACKCURRANT FLAV. 25g (24/Box)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300151','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI B/CURRANT.1x24','zazi_blackcurrant.jpg','1','0'),(6,'152','ZAZI ORANGE FLAVOUR 25g (24/BOX)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300152','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI ORANGE 1x24','zazi_orange.jpg','1','0'),(7,'153','ZAZI MANGO FLAVOUR 25g (24/BOX)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300153','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI MANGO FL. 1x24','zazi_mango.jpg','1','0'),(8,'154','ZAZI 3-FRUIT FLAVOURS 25g (24/BOX)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300154','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI 3-FRUITS.1x24',NULL,'1','0'),(9,'155','ZAZI MENTHOL EUCALYPTUS XTRA-STRONG 25g.(24/Box)','16',NULL,'24',29.52,'32.472','1.23',1.8,'931264300155','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI MENTHOL EUCALY',NULL,'1','0'),(10,'157','ZAZI SUGARFREE GUM 1kg BAG BULK','16',NULL,'1',18,'19.8','18',32,'?','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ZAZI GUM  1kg BAG',NULL,'1','0');
DROP TABLE IF EXISTS `rep_rep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rep_rep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `state` enum('1','2','3','4','5','6','7','8','9') NOT NULL DEFAULT '1',
  `carid` varchar(254) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` enum('6') NOT NULL DEFAULT '6',
  `repid1` int(11) DEFAULT NULL,
  `repid2` int(11) DEFAULT NULL,
  `repid3` int(11) DEFAULT NULL,
  `repid4` int(11) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `login` (`login`),
  KEY `state` (`state`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `talents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `talents` (
  `ID` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(20) NOT NULL DEFAULT '',
  `Lastname` varchar(20) NOT NULL DEFAULT '',
  `Street` varchar(30) NOT NULL DEFAULT '',
  `State` varchar(5) NOT NULL DEFAULT '',
  `City` varchar(30) NOT NULL DEFAULT '',
  `Postcode` varchar(4) NOT NULL DEFAULT '',
  `Country` varchar(30) DEFAULT NULL,
  `Hometel` varchar(10) NOT NULL DEFAULT '',
  `Upload` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `Date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=20066 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `talents` VALUES (20065,'David','Oabile','29 William St','QLD','Rockhampton','4700','Australia','0749273633','1-01 Vivaldi_2.mp3','davido@cyberoz.com.au','2006-11-05');
DROP TABLE IF EXISTS `tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(200) NOT NULL,
  `lft` int(11) NOT NULL,
  `rt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `text` (`text`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `tree` VALUES (1,'Food',1,18),(3,'Fruit',2,11),(4,'Red',3,6),(5,'Cherry',4,5),(6,'Yellow',7,10),(7,'Banana',8,9),(8,'Meat',12,17),(9,'Beef',13,14),(10,'Pork',15,16);
DROP TABLE IF EXISTS `wholesale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wholesale` (
  `product` varchar(50) NOT NULL DEFAULT '',
  `pname` varchar(50) NOT NULL DEFAULT '',
  `info` varchar(50) NOT NULL DEFAULT '',
  `refNo` varchar(50) NOT NULL DEFAULT '',
  `qty` int(11) NOT NULL DEFAULT '0',
  `cdisplay` varchar(50) NOT NULL DEFAULT '',
  `tuneNo` varchar(50) NOT NULL DEFAULT '',
  `pcartons` varchar(50) NOT NULL DEFAULT '',
  `barcode` varchar(50) NOT NULL DEFAULT '',
  `wprice` varchar(20) NOT NULL DEFAULT '',
  `rprice` varchar(20) NOT NULL DEFAULT '',
  `display` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`product`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `wholesale` VALUES ('1','Zazi Orange','Seville Oranges + gum Arabic','1234',200,'2 by 2','3','00000','000000','1.80','2.00','./boughtorange'),('2','Zizi Black & White','Sugar Free, Gluten Free, Low Carb, Low G.I. and Di','soon',120,'soon','soon','soon','soon','soon','soon','soon'),('3','Zazi Strawberry','Sugar Free','soon',240,'soon','sonn','sonn','sonn','soon','soon','soon'),('4','Zizi White & Green','Fresh,Strong but Delicate and Long lasting','soon',20000,'sonn','soon','soon','soon','$1.80','$2.00','soon'),('5','Zazi Mango','soon','soon',2415,'sonn','soon','soon','soon','soon','soon','soon'),('6','Zizi Red & White','soon','soon',0,'soon','soon','soon','soon','soon','soon','soon'),('7','Zizi Black Currant','soon','soon',0,'soon','soon','soon','soon','soon','soon','soon'),('8','Zazi Licorice','soon','soon',0,'soon','soon','soon','soon','soon','soon','soon');
