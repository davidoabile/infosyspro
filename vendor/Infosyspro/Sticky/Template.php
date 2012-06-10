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
  * @subpackage Template
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
  * @subpackage Template
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 class Template extends AbstractSticky
 {
     //put your code here
     public function getPublishingOptions(Array $options)
     {
        $values = $options['values'];
        unset($options->values);
       
         $formOptions = array(
             'created_by' => array( 'title' => 'Created By',
                                         'name' => 'ioptions[created_by]',
                                         'type' => 'textbox',
                                         'value' => @$values['created_by'],
                                         'tooltip' => '',
                                    ),
             'show_title'     => array( 'title' => 'Show Title',
                                        'name' => 'ioptions[show_title]',                                     
                                        'type' => 'radio',
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
             'show_author'     => array( 'title' => 'Show Author',
                                        'name' => 'ioptions[show_author]',                                     
                                        'type' => 'radio',
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
             'show_intro'     => array( 'title' => 'Show Intro',
                                        'name' => 'ioptions[show_intro]',                                      
                                        'type' => 'radio',
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
             'show_create_date'     => array( 'title' => 'Show Date Created',
                                        'name' => 'ioptions[show_create_date]',                                      
                                        'type' => 'radio',
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
              'show_modify_date'     => array( 'title' => 'Show Date Modified',
                                        'name' => 'ioptions[show_modify_date]',                                      
                                        'type' => 'radio',
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
             'show_hits'     => array( 'title' => 'Show Hits',
                                        'name' => 'ioptions[show_hits]',                                      
                                        'type' => 'radio',                                        
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
             'show_vote'     => array( 'title' => 'Show Vote',
                                        'name' => 'ioptions[show_vote]',                                   
                                        'type' => 'radio',                                        
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ),
             'enable_blog_reply'     => array( 'title' => 'Enable Blog Replies',
                                        'name' => 'ioptions[enable_blog]',                                     
                                        'type' => 'radio',                                        
                                        'tooltip' => '',
                                        'value1'  => '1',
                                        'value2'  => '0',
                                        'label1'  => 'Yes',
                                        'label2'  => 'No'
                                    ), 
           
         );
         $data = '<ul class="adminformlist">';
         
           $content = '';
           
           
           if($options['contentType'] != 'blog') {
               unset($formOptions['enable_blog_reply']);
           }
         
         foreach($formOptions as $name => $element ) {
           $trueChecked = '';
           $falseChecked = '';
             
             if($element['type'] == 'radio') {
                 $content .= '<li><label id="iform_' . $name .'_lbl" for="iform_' . $name . '" class="hasTip" 
                              title="'. $element['tooltip'] .'"> ' . $element['title'] . '</label>					
                              <fieldset id="id_' . $name. $element['value1'] .'" class="radio"> ' ;
                 if(isset($values[$name]) && $values[$name] == 1) {
                    $trueChecked = 'checked = "checked"';
                 } elseif(@$values[$name] == 0) {
                    $falseChecked = 'checked = "checked"';
                 }   
                 $content .= ' <input type="radio" id="id_' . $name. $element['value1'] .'"  name="' . $element['name'] .'" value="' . $element['value1'] .'" '. $trueChecked .' />
                              <label for="' . $name. $element['value1'] .'">' . $element['label1'] .'</label>
                               <input type="radio" id="id_' . $name. $element['value2'] .'" name="' . $element['name'] .'" value="' . $element['value2'] .'" ' . $falseChecked .' />
                              <label for="' . $name. $element['value2'] .'">' . $element['label2'] .'</label>
                             </fieldset></li>';
                 
             } elseif($element['type'] == 'textbox') {
                 $content .= ' <li><label id="jform_' . $name .'_lbl" for="' . $name .'" class="hasTip" 
                               title="' . $element['tooltip'] .'">' . $element['title'] .'</label>					
                                         <div class="fltlft">
                                            <input type="text" id="id_' . $name .'" value="' . $element['value'] .'" name="' . $element['name'] .'" />
                                        </div></li>';
             }
         }
        
         return $data. $content . '</ul>';
         /*
          *      
                                    <li><label id="iform_show_intro_lbl" for="iform_show_intro" class="hasTip" title="Created Date::Created Date">Show Intro</label>					
                                           <fieldset id="iform_show_intro" class="radio"><input type="radio" id="jform_offline0" name="iform[show_intro]" value="1" />
          * 
          * <label for="iform_offline0">Yes</label>
                                                <input type="radio" id="jform_offline1" name="jform[offline]" value="0"/><label for="jform_offline1">No</label></fieldset>
                                    </li>
          * 
          * 
          * <ul class="adminformlist">
                                    <li><label id="jform_created_by-lbl" for="jform_created_by" class="hasTip" title="Created by::You can change here the name of the user who created the article.">Created by</label>					
                                         <div class="fltlft">

                                            <input type="text" id="jform_created_by_name" value="Select a User" disabled="disabled" />
                                        </div>
                                        <div class="button2-left">
                                            <div class="blank">
                                                <a class="modal_jform_created_by" title="Select User" href="index.php?option=com_users&amp;view=users&amp;layout=modal&amp;tmpl=component&amp;field=jform_created_by" rel="{handler: 'iframe', size: {x: 800, y: 500}}">
                                                    Select User</a>
                                            </div>
                                        </div>
                                        <input type="hidden" id="jform_created_by_id" name="jform[created_by]" value="0" /></li>

                                    <li><label id="jform_created_by_alias-lbl" for="jform_created_by_alias" class="hasTip" title="Created by alias::You can enter here an alias to be displayed instead of the name of the user who created the article.">Show Title</label>					
                                        <input type="text" name="iform[show_title]" id="jform_created_by_alias" value="" class="inputbox" size="20"/></li>
                                        
                                    <li><label id="iform_show_intro_lbl" for="iform_show_intro" class="hasTip" title="Created Date::Created Date">Show Intro</label>					
                                           <fieldset id="iform_show_intro" class="radio"><input type="radio" id="jform_offline0" name="iform[show_intro]" value="1" /><label for="iform_offline0">Yes</label>
                                                <input type="radio" id="jform_offline1" name="jform[offline]" value="0"/><label for="jform_offline1">No</label></fieldset>
                                    </li>
                                    
                                    <li><label id="iform_show_intro_lbl" for="iform_show_intro" class="hasTip" title="Created Date::Created Date">Show Created Date</label>					
                                           <fieldset id="iform_show_intro" class="radio"><input type="radio" id="jform_offline0" name="iform[show_intro]" value="1" /><label for="iform_offline0">Yes</label>
                                                <input type="radio" id="jform_offline1" name="jform[offline]" value="0"/><label for="jform_offline1">No</label></fieldset>
                                    </li>
                                    
                                    <li><label id="iform_show_intro_lbl" for="iform_show_intro" class="hasTip" title="Created Date::Created Date">Show Hits</label>					
                                           <fieldset id="iform_show_intro" class="radio"><input type="radio" id="jform_offline0" name="iform[show_intro]" value="1" /><label for="iform_offline0">Yes</label>
                                                <input type="radio" id="jform_offline1" name="jform[offline]" value="0"/><label for="jform_offline1">No</label></fieldset>
                                    </li>
                                    <li><label id="iform_show_intro_lbl" for="iform_show_intro" class="hasTip" title="Created Date::Created Date">Show Intro</label>					
                                           <fieldset id="iform_show_intro" class="radio"><input type="radio" id="jform_offline0" name="iform[show_intro]" value="1" /><label for="iform_offline0">Yes</label>
                                                <input type="radio" id="jform_offline1" name="jform[offline]" value="0"/><label for="jform_offline1">No</label></fieldset>
                                    </li>
                                    


                                </ul>
          */
     }
 }

 