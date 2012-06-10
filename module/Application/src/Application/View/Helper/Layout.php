<?php
namespace Application\View\Helper;

 class Layout
 {
    

       protected $liveSite = '';
       //$template_path = $this->baseurl . '/templates/' . $this->template;
       //$preset_style = $this->params->get("presetStyle", "dark-red");
      // $frontpage_component = $this->params->get("enableFrontpage", "show");
      // $enable_ie6warn = ($this->params->get("enableIe6warn", 0) == 0) ? "false" : "true";
       protected $fontFamily = "mynxx";
       protected $templateWidth = "959";      
       protected $leftInsetWidth = 0;
       protected $rightInsetWidth = 0;
       //$splitmenu_col = $this->params->get("splitmenuCol", "rightcol");
       //$menu_name = $this->params->get("menuName", "mainmenu");
       //$menu_type = $this->params->get("menuType", "moomenu");
       //$menu_rows_per_column = $this->params->get("menuRowsPerColumn");
       //protected $menuColumns = 210;
       //$menu_multicollevel = $this->params->get("menuMultiColLevel", 1);
       //$default_font = $this->params->get("defaultFont", "default");
       protected $showLogo = true;
       protected $showLogoSlogan = true;
       protected $logoSlogan = 'Powered by Infosyspro';
       protected $showBottomLogo = true;
       protected $showHomeButton = true;
       //$show_textsizer = ($this->params->get("showTextsizer", 1) == 0) ? "false" : "true";
       protected $showCart = true;
      // $show_fontchanger = ($this->params->get("showFontchanger", 1) == 0) ? "false" : "true";
       protected $showCopyright = false;
       protected $showCaseCount = 0;
       protected $showCaseWidth = '';
       
       protected $mainUsercount = 0;
       protected $mainUserWidth = '';
       protected $mainUser2count = 0;
       protected $mainUser2Width = '';
    
       protected $mainUser3count = 0;
       protected $mainUser3Width = '';
       protected $mainBottomCount = 0;
       protected $mainBottomWidth = '';
       
       protected $leftColumnWidth = 0;
       protected $rightColumnWidth = 0;
       //   $js_compatibility = ($this->params->get("jsCompatibility", 0) == 0) ? "false" : "true";
/*
       // moomenu options
       $moo_bgiframe = ($this->params->get("moo_bgiframe'", "0") == 0) ? "false" : "true";
       $moo_delay = $this->params->get("moo_delay", "500");
       $moo_duration = $this->params->get("moo_duration", "600");
       $moo_fps = $this->params->get("moo_fps", "200");
       $moo_transition = $this->params->get("moo_transition", "Sine.easeOut");

       $moo_bg_enabled = ($this->params->get("moo_bg_enabled", "1") == 0) ? "false" : "true";
       $moo_bg_over_duration = $this->params->get("moo_bg_over_duration", "500");
       $moo_bg_over_transition = $this->params->get("moo_bg_over_transition", "Expo.easeOut");
       $moo_bg_out_duration = $this->params->get("moo_bg_out_duration", "600");
       $moo_bg_out_transition = $this->params->get("moo_bg_out_transition", "Sine.easeOut");

       $moo_sub_enabled = ($this->params->get("moo_sub_enabled", "1") == 0) ? "false" : "true";
       $moo_sub_opacity = $this->params->get("moo_sub_opacity", "0.95");
       $moo_sub_over_duration = $this->params->get("moo_sub_over_duration", "50");
       $moo_sub_over_transition = $this->params->get("moo_sub_over_transition", "Expo.easeOut");
       $moo_sub_out_duration = $this->params->get("moo_sub_out_duration", "600");
       $moo_sub_out_transition = $this->params->get("moo_sub_out_transition", "Sine.easeIn");
       $moo_sub_offsets_top = $this->params->get("moo_sub_offsets_top", "0");
       $moo_sub_offsets_right = $this->params->get("moo_sub_offsets_right", "1");
       $moo_sub_offsets_bottom = $this->params->get("moo_sub_offsets_bottom", "0");
       $moo_sub_offsets_left = $this->params->get("moo_sub_offsets_left", "1");



       global $Itemid, $modules_list, $mainmodulesBlocks, $template_real_width, $leftcolumn_width, $rightcolumn_width, $menu_rows_per_column, $menu_columns, $menu_multicollevel;
      */

     protected $mainmodulesBlocks = array(
             'case1' => array('user1', 'user2', 'user3'),
             'case2' => array('user4', 'user5', 'user6'),
             'case3' => array('user7', 'user8', 'user9'),
             'case4' => array('bottom', 'bottom2', 'bottom3'),
             'case5' => array('showcase', 'showcase2', 'showcase3')
         );
     protected $moduleCount = null;
     protected  $config = null;
     
     public function __construct($config)
     {
         $moduleCount = $config->moduleCount;
        
        // unset($config);
        
         if(isset($moduleCount->showcase)) {
            $this->showCaseCount = (@$moduleCount->showcase > 0) + (@$moduleCount->showcase2 > 0) + (@$moduleCount->showcase3 > 0);
            $this->showCaseWidth = $this->showCaseCount > 0 ? ' w' . floor(99 / $this->showCaseCount) : '';
         }
         
        
         if(isset($moduleCount->user1) || isset($moduleCount->user2) || isset($moduleCount->user3)) {
        
            $this->mainUsercount = (@$moduleCount->user1 > 0) + (@$moduleCount->user2 > 0) + (@$moduleCount->user3 > 0);
            $this->mainUserWidth = $this->mainUsercount > 0 ? ' w' . floor(99 / $this->mainUsercount) : '';
         }
         
         if(isset($moduleCount->user4) || isset($moduleCount->user5) || isset($moduleCount->user6)) {
            $this->mainUser2Count = (@$moduleCount->user4 > 0) + (@$moduleCount->user5 > 0) + (@$moduleCount->user6 > 0);
            $this->mainUser2Width = $this->mainUser2Count > 0 ? ' w' . floor(99 / $this->mainUser2Count) : '';
         }
         if(isset($moduleCount->user7) || isset($moduleCount->user8) || isset($moduleCount->user9)) {
            $this->mainUser3Count = (@$moduleCount->user7 > 0) + (@$moduleCount->user8 > 0) + (@$moduleCount->user9 > 0);
            $this->mainUser3Width = $this->mainUser3Count > 0 ? ' w' . floor(99 / $this->mainUser3Count) : '';
         }
         
         if(isset($moduleCount->bottom) || isset($moduleCount->bottom2) || isset($moduleCount->bottom3)) {
            $this->mainBottomCount = (@$moduleCount->bottom > 0) + (@$moduleCount->bottom2 > 0) + (@$moduleCount->bottom3 > 0);
            $this->mainBottomWidth = $this->mainBottomCount > 0 ? ' w' . floor(99 / $this->mainBottomCount) : '';
         }
         
         if(isset($moduleCount->left) || isset($moduleCount->searchLeft)) {
            $this->leftColumnWidth = (@$moduleCount->left > 0 or @$moduleCount->searchLeft > 0 or ($subnav)) ? $config->leftColumnWidth : 0;
         }
        if(isset($moduleCount->right) || isset($moduleCount->searchRight)) {
            $this->rightColumnWidth = ((@$moduleCount->right > 0 or @$moduleCount->searchRight > 0 or ($subnav))) ? $config->rightColumnWidth : 0;
         }

         $this->colMode = "s-c-s";
         if ($this->leftColumnWidth == 0 and $this->rightColumnWidth > 0)
             $this->colMode = "x-c-s";
         if ($this->leftColumnWidth > 0 and $this->rightColumnWidth == 0)
             $this->colMode = "s-c-x";
         if ($this->leftColumnWidth == 0 and $this->rightColumnWidth == 0)
             $this->colMode = "x-c-x";
        
         if(isset($moduleCount->inset)) {
         $this->leftInsetWidth = ($moduleCount->inset > 0 ) ? ' w' . floor(99 / $moduleCount->inset) : "0";
        
         }
         if(isset($moduleCount->inset2)) {
         $this->rightInsetWidth = ($moduleCount->inset2 > 0 ) ? $config->rightInsetWidth : "0";
         }
         
         $this->templateWidth = 'margin: 0 auto; width: ' . $config->width . 'px;';         
         
        
     }

     public function renderMenu() {
         
     }
     
     protected function isIe($version = false)
     {

         $agent = $_SERVER['HTTP_USER_AGENT'];

         $found = strpos($agent, 'MSIE ');
         if ($found) {
             if ($version) {
                 $ieversion = substr(substr($agent, $found + 5), 0, 1);
                 if ($ieversion == $version)
                     return true;
                 else
                     return false;
             } else {
                 return true;
             }
         } else {
             return false;
         }
         if (stristr($agent, 'msie' . $ieversion))
             return true;
         return false;
     }

     public function modulesClasses($case, $loaded_only = false)
     {
         $modules = $this->mainmodulesBlocks[$case];
         $loaded = 0;
         $loadedModule = array();
         $classes = array();

         foreach ($this->mainmodulesBlocks[$case] as $block)
             if ($this->moduleCount->$block > 0) {
                 $loaded++;
                 array_push($loadedModule, $block);
             }
         if ($loaded_only)
             return $loaded;

         $width = $this->getModuleWidth($case, $loaded);

         switch ($loaded) {
             case 1:
                 $classes[$loadedModule[0]][0] = 'full';
                 $classes[$loadedModule[0]][1] = $width[0];
                 break;
             case 2:
                 for ($i = 0; $i < count($loadedModule); $i++) {
                     if (!$i) {
                         $classes[$loadedModule[$i]][0] = 'first';
                         $classes[$loadedModule[$i]][1] = $width[0];
                     } else {
                         $classes[$loadedModule[$i]][0] = 'last';
                         $classes[$loadedModule[$i]][1] = $width[1];
                     }
                 }
                 break;
             case 3:
                 for ($i = 0; $i < count($loadedModule); $i++) {
                     if (!$i) {
                         $classes[$loadedModule[$i]][0] = 'first';
                         $classes[$loadedModule[$i]][1] = $width[0];
                     } elseif ($i == 1) {
                         $classes[$loadedModule[$i]][0] = 'middle';
                         $classes[$loadedModule[$i]][1] = $width[1];
                     } else {
                         $classes[$loadedModule[$i]][0] = 'last';
                         $classes[$loadedModule[$i]][1] = $width[2];
                     }
                 }
                 break;
         }

         return $classes;
     }

     protected  function getModuleWidth($type, $loaded)
     {
         
         $width = ($this->config->templateRealWidth - 2) - (($this->leftColumnWidth == "0") ? 0 : $this->leftColumnWidth + 1) .
                  - (($this->rightColumnWidth == "0") ? 0 : $this->rightColumnWidth + 1) - $this->leftBannerWidth - $this->rightBannerWidth;

         $ieFix = ($this->leftBannerWidth == "0") ? 0 : 0;
         $ieFix += ($rightBannerWidth == "0") ? 0 : 0;

         $result = array();

         $widthOriginal = $width;

         switch ($loaded) {
             case 1:
                 $result[0] = $widthOriginal;
                 if (isIe(6))
                     $result[0] -= $ieFix;
                 break;
             case 2:
                 $width = floor($width / 2);
                 $result[0] = $width - 1;
                 $result[1] = $widthOriginal - ($result[0] + 2);
                 if (isIe(6)) {
                     $result[0] -= 1;
                     $result[1] -= $ieFix;
                 }
                 break;
             case 3:
                 $width = floor($width / 3);
                 $result[0] = $result[1] = $width - 1;
                 $result[2] = $widthOriginal - ($result[0] + $result[1] + 2);
                 if (isIe(6)) {
                     $result[0] -= 1;
                     $result[1] -= 1;
                     $result[2] -= $ieFix;
                 }
                 break;
         }

         return $result;
     }

     public function getMainWidth()
     {
         $mainWidth = getModuleWidth(false, 1);
         $result = $mainWidth[0];

         return $result;
     }

     public function toArray()
     {
         $setUp = new \stdClass();
         foreach ( $this as $k =>$v) {
             $setUp->{$k} = $v;
         }
         return $setUp;
     }
 }

 