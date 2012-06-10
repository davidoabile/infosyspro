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

use Zend\View\Helper\AbstractHelper as ZendHelperAbstract;
 
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

class TinyMce extends ZendHelperAbstract
{
    
    protected $_enabled = false;
    protected $_defaultScript = 'http://sozfo.googlecode.com/svn/trunk/scripts/tiny_mce.js';

    protected $_supported = array(
        'mode'      => array('textareas', 'specific_textareas', 'exact', 'none'),
        'theme'     => array('simple', 'advanced'),
        'format'    => array('html', 'xhtml'),
        'languages' => array('en'),
        'plugins'   => array('style', 'layer', 'table', 'save',
                             'advhr', 'advimage', 'advlink', 'emotions',
                             'iespell', 'insertdatetime', 'preview', 'media',
                             'searchreplace', 'print', 'contextmenu', 'paste',
                             'directionality', 'fullscreen', 'noneditable', 'visualchars',
                             'nonbreaking', 'xhtmlxtras', 'imagemanager', 'filemanager','template'));

    protected $_config = array('mode'  =>'textareas',
                               'theme' => 'simple',
                               'element_format' => 'html');
    protected $_scriptPath;
    protected $_scriptFile;
    protected $_useCompressor = false;
    protected $view;
    

    public function __construct()
    {
       // parent::__construct();
      
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Zend_Exception('Invalid tinyMce property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Zend_View_Exception('Invalid tinyMce property');
        }
        return $this->$method();
    }

    public function setOptions(array $options, $view)
    {
        if( null === $this->view  ) {
            $this->view = $view;
        }

        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            } else {
                $this->_config[$key] = $value;
            }
        }
        return $this;
    }

    public function tinyMce ()
    {
        return $this;
    }

    public function setScriptPath ($path)
    {
        $this->_scriptPath = rtrim($path,'/');
        return $this;
    }

    public function setScriptFile ($file)
    {
        $this->_scriptFile = (string) $file;
    }

    public function setCompressor ($switch)
    {
        $this->_useCompressor = (bool) $switch;
        return $this;
    }

    public function render()
    {       
        if (false === $this->_enabled) {
            $this->_renderScript();
            $this->_renderCompressor();
            $this->_renderEditor();
        }
        $this->_enabled = true;
    }

    protected function _renderScript ()
    {
        if(null === $this->_scriptFile) {
            $script = $this->_defaultScript;
        } else {
            $script = $this->_scriptPath . '/' . $this->_scriptFile;
        }

        $this->view->headScript()->appendFile($script);
        return $this;
    }

    protected function _renderCompressor ()
    {
        if (false === $this->_useCompressor) {
            return;
        }

        if (isset($this->_config['plugins']) && is_array($this->_config['plugins'])) {
            $plugins = $this->_config['plugins'];
        } else {
            $plugins = $this->_supported['plugins'];
        }

        $script = 'tinyMCE_GZ.init({' . PHP_EOL
                . 'themes: "' . implode(',', $this->_supported['theme']) . '",' . PHP_EOL
                . 'plugins: "'. implode(',', $plugins) . '",' . PHP_EOL
                . 'languages: "' . implode(',', $this->_supported['languages']) . '",' . PHP_EOL
                . 'disk_cache: true,' . PHP_EOL
                . 'debug: false' . PHP_EOL
                . '});';

        $this->view->headScript()->appendScript($script);
        return $this;
    }

    protected function _renderEditor ()
    {
        $script = 'tinyMCE.init({' . PHP_EOL;

        $params = array();
        foreach ($this->_config as $name => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            if (!is_bool($value)) {
                $value = '"' . $value . '"';
            }
            $params[] = $name . ': ' . $value;
        }
        $script .= implode(',' . PHP_EOL, $params) . PHP_EOL;
        $script .= '});';

        $this->view->headScript()->appendScript($script);
        return $this;
    }
}


 