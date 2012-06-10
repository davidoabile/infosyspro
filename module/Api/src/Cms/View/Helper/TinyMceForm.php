<?php
 
 namespace Cms\View\Helper;
 use Zend\Form\Element\Textarea as ZendTextarea,
     Zend\Config\Ini as ZendIni,
     Zend\View\Helper as ZendHelper; 
 
 
 class TinyMceForm extends ZendTextarea implements ZendHelper
{
    public function __construct($options) 
    {
        $iniFile =  __DIR__  . '/../../../../configs/tinyMCE.ini';    
        $configSection = 'moderator';
        
        $name = $options['name'];
        unset($options['name']);
        
        if(isset($options['iniFile'])) {
            $iniFile = $options['iniFile'];
            unset($options['iniFile']);
        }
        
        if(isset($options['configSection'])) {
            $configSection = $options['configSection'];
            unset($options['configSection']);
        }
        
        $options['editorOptions'] = new ZendIni( $iniFile, $configSection );
       // $conf = $options['editorOptions']->toArray();
      //  $config = array_merge($options, $conf);
        
       // unset($options);
        
        parent::__construct($name, $options);
      
    }
    /**
     * Use formTextarea view helper by default
     * @var string
     */
    public $helper = 'Cms\View\Helper\FormTinyMce';
    
     /**
     * View object
     *
     * @var \Zend\View\Renderer
     */
    protected $view = null;

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
    
   
}
