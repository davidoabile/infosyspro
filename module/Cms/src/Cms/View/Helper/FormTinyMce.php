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

use  Zend\View\Helper\FormTextarea;

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

class FormTinyMce extends FormTextarea 
{
    protected $_tinyMce;
  
    public function __invoke ($name='david', $value = null, $attribs = null)
    {        
      
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable
        
        $mce = new TinyMce();
        $disabled = '';
        if ($disable) {
            $disabled = ' disabled="disabled"';
        }

       
        
        if (empty($attribs['rows'])) {
            $attribs['rows'] = (int) $this->rows;
        }
        if (empty($attribs['cols'])) {
            $attribs['cols'] = (int) $this->cols;
        }

        if (isset($attribs['editorOptions'])) {
            if ($attribs['editorOptions'] instanceof \Zend\Config\Ini) {
                $attribs['editorOptions'] = $attribs['editorOptions']->toArray();
            }
            
            $mce->setOptions($attribs['editorOptions'], $this->view);           
        }
         unset($attribs['editorOptions']);
        $mce->render();

        $xhtml = '<textarea name="' . $this->view->vars()->escape($name ). '"'
                . ' id="' . $id . '"'
                . $disabled
                . $this->_htmlAttribs($attribs) . '>'
                . $this->view->vars()->escape($value) . '</textarea>';
      
        return $xhtml;
    }
    
    
    
    /**
     * Set the View object
     *
     * @param  \Zend\View\Renderer $view
     * @return \Zend\View\Helper\AbstractHelper
     */
    public function setView(\Zend\View\Renderer $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Get the view object
     * 
     * @return null|AbstractHelper
     */
    public function getView()
    {
        return $this->view;
    }
    
      /**
     * Converts an associative array to a string of tag attributes.
     *
     * @access public
     *
     * @param array $attribs From this array, each key-value pair is
     * converted to an attribute name and value.
     *
     * @return string The XHTML for the attributes.
     */
    protected function _htmlAttribs($attribs)
    {
        $xhtml = '';
        
        foreach ((array) $attribs as $key => $val) {
            $key = $this->view->vars()->escape($key);
            
            
            
            if (('on' == substr($key, 0, 2)) || ('constraints' == $key)) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    $val = \Zend\Json\Json::encode($val);
                }
                // Escape single quotes inside event attribute values.
                // This will create html, where the attribute value has
                // single quotes around it, and escaped single quotes or
                // non-escaped double quotes inside of it
                $val = str_replace('\'', '&#39;', $val);
            } else {
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
                $val = $this->view->vars()->escape($val);
            }

            if ('id' == $key) {
                $val = $this->_normalizeId($val);
            }
            if(!is_string($val) ){
                
                 continue;
            }
            if (strpos($val, '"') !== false) {
                $xhtml .= " $key='$val'";
            } else {
                $xhtml .= " $key=\"$val\"";
            }

        }
       
        return $xhtml;
    }
    
}


 