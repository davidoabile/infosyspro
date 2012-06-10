<?php

 /* namespace */
namespace Infosyspro\Sticky;


 /**
  * Class for rendering configuration page
  *
  * @uses       \Infosyspro\AbstractSticky
  * @category   Infosyspro
  * @package    Infosyspro
  * @subpackage Configuration
  * @copyright  Copyright (c) 2011-2012 Infosyspro Australia. (http://davidoabile.com)
  * @license    http://infosyspro.com/license     New Infosyspro License
  * @author    David Oabile <doabile@infosyspro.com.au>
  * 
  */
 class Configuration extends AbstractSticky
 {
     
     public function newConfig($options )
     {
          $table = $this->locator->get('Dbtable');
          $table->setOptions(array('name' => 'TbLanguages'));
          $langs = $table->fetchAll(); 
          $lan =  $this->locator->get('translator');
         ob_start();
      ?>
      
                            <fieldset class="adminform">
                                <legend><?php echo $lan->translate('AddNewConfiguration') ?></legend>
                                <label id="form_rules-lbl" for="jform_rules" class=""><?php echo $lan->translate('configurationNotes') ?></label>
                                <div class="clr"> </div>
                                <div id="new-config-sliders" class="pane-sliders">

                                  <div class="width-100">
                                <fieldset class="loginform">
                                  
                                    <table class="group-rules">
                                                            <thead>
                                                                <tr>
                                                                    <th class="actions" id="actions-th1">
                                                                        <span class="acl-action"><label id="user-lbl" class="hasTip" title="<?php echo $lan->translate('ConfigurationKeydescription') ?>"><?php echo $lan->translate('ConfigurationKey') ?></label></span>
                                                                    </th>

                                                                    <th class="settings" id="settings-th1">
                                                                        <span class="acl-action"><label id="pass-lbl" class="hasTip" title="<?php echo $lan->translate('configurationValueDescription') ?>"><?php echo $lan->translate('configurationValue') ?></label>	</span>
                                                                    </th>
                                                                     <th class="settings" id="settings-th2">
                                                                        <span class="acl-action"><label id="conf_language" for="iform_config_language" class="hasTip" title="<?php echo $lan->translate('configurationLanguageDescription') ?>"><?php echo $lan->translate('configurationLanguage') ?></label>	</span>
                                                                    </th>
                                                                     <th class="settings" id="th">
                                                                        <span class="acl-action"><label id="conf_language" for="iform_config_category" class="hasTip" title="<?php echo $lan->translate('configurationCategoryDescription') ?>"><?php echo $lan->translate('configurationCategory') ?></label>	</span>
                                                                    </th>
                                                                    <th class="settings" id="settings-th3">
                                                                        <span class="acl-action"><label id="conf_description" for="iform_config_description" class="hasTip" title="<?php echo $lan->translate('configurationDescriptionDescription') ?>"><?php echo $lan->translate('configurationDescription') ?></label>					</span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                             <tbody>
                                                          <?php
                                                           for($i=0; $i <= 2; $i++ ) :
                                                               
                                                           ?>
                                                           
                                                                <tr>
                                                                    <td>
                                                                         <input type="text" name="iform[config_key][]"  value="" size="50"/>
                                                                    </td><td>
                                                                        				
                                                                        <input type="text" name="iform[config_value][]" value=""  size="25"/>
                                                                    </td>
                                                                    <td>
                                                                      			
                                                                        <select id="iform_select" name="iform[config_language][]" class="required">
                                                                             <option value="9999" >All Languages</option>
                                                                             <?php foreach($langs as $k =>$v) :                                                                                 
                                                                                 $selected = ($v->title =='English' ? 'selected' : '');
                                                                                 
                                                                              ?>	
                                                                                
                                                                                <option value="<?php echo $v->lang_id ?>" <?php echo $selected; ?> ><?php echo $v->title ?></option>
                                                                              <?php endforeach ?> 
                                                                          </select>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        				
                                                                        <input type="text" name="iform[config_category][]" value=""  size="25"/>
                                                                    </td>
                                                                    <td>
                                                                       
                                                                        <input type="text" name="iform[config_description][]" value="" size="50"/> 
                                                                    </td>
                                                                </tr>
                                                                <?php endfor ?>
                                                            </tbody>
                                    </table>
                                    <div style="text-align:right;"><input type="submit"  value="<?php echo $lan->translate('saveConfiguration') ?>" /></div>
                                </fieldset>
                                      <div class="clr"></div>
                                    
                            </div>
                                    <div class="rule-notes">
                                       <?php echo $lan->translate('configurationRules') ?>

                                    </div></div>			</fieldset>
                      
     <?php
      $content = ob_get_contents();
      ob_clean();
      
      return $content;
     }
     
     
      public function siteConfig($options )
     {
      return false;
     }
     
     
 }

 