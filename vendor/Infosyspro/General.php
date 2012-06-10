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

namespace Infosyspro;

use Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager,
    Application\Model\ThisTable;
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

class General {

    protected $events;
    protected $config;

    public function __construct($config = array())
    {
        $this->config = $config;
       
    }
    
    public function getTable($config = array('name' => 'products'))
    {
        
      $t = new ThisTable($this->config);
      $t->setOptions($config);
      
      return $t->fetchAll();
    }
    
    
    public function events(EventCollection $events = null) {
        if (null !== $events) {
            $this->events = $events;
        } elseif (null === $this->events) {
            $this->events = new EventManager(__CLASS__);
        }
               
        return $this->events;
    }
    
    public function bar($baz, $bat = null)
    {
        $params = compact('baz', 'bat');
        $this->events()->trigger(__FUNCTION__, $this, $params);
    }
    
    public function bootstrap()
    {
       // $di = new \Zend\Di\InstanceManager();
        $e = \Zend\EventManager\StaticEventManager::getInstance(); 
       // $ev = $e->getEvents('Zend\Mvc\Controller\ActionController');
        var_dump($e); exit;
    }
    
    
    public function shout($e) {
        var_dump($e->getParam('app'));
        die('dead');
    }
}

/*
 
        
      # $t = new General();
      # $t->events()->attach('bar',array($t,'shout'));
      # var_dump($t->bar('david','Oabile'));
      // $fc = \Zend\Controller\Front::getInstance();
       //var_dump($fc);
        //var_dump($this->events->getParam('application'));
       // $e = \Zend\EventManager\StaticEventManager::getInstance();  
       // var_dump($e->getE() );
      //  exit;
      // $events = $this->getLocator();
       //$t = new ThisTable(array('name' => 'admin'));
       
      // $this->table->
     // var_dump($this->table->fetchAll()); exit;
     //$infosys = $events->get('companylib');
     // var_dump($infosys->init());
     // var_dump($table->getTable(array('name' => 'admin')));
     // $r = new mylibrary();
     //  $broker = $events->get('broker');
      // $url = $conf->load('url');
     //  $helper = new $url();
       //$instance = $infosys->getInstance();
     
      //var_dump($config->di->instance->mysql1);
     // $db = $infosys->getDbConfig(); 
        
      // $br =  $broker->getRegisteredPlugins();
      // var_dump(array_keys($br));
    //  exit;
    //  $conf = $events->get('mysql1');
    //  $config->name = 'admin';
     // $t = new ThisTable($db);
    //  $t->setOptions(array('name' => 'admin'));
    // $infosys = $events->get('companylib');
    //  var_dump($infosys->getTable(array('name' => 'admin')));
     // exit;
       /* 
    
     
 * 
 private function handleWSDL() {
        $autodiscover = new \Zend\Soap\AutoDiscover();
        $autodiscover->setClass('SoapServer');
        $autodiscover->handle();
    }
    
    private function handleSOAP() {
       
        $soap = new \Zend\Soap\Server(null, array('uri' => $this->_WSDL_URI)); 
        $soap->setClass('Infosys\SoapServer');
        $soap->handle();
    }
    
    public function clientAction() {
    
         $client = $this->locator->get('soapClient');
	var_dump($client->getName());exit;        
    }
    
 * 
 * 
 * 
 * // $layout = $view->plugin('layout');
    //  $layout->getLayout()->setLayout('layout/cmslayout.phtml');
   //  $list = new \Application\View\Listener($view,'layouts/layout.phtml' );
     //$list->setLayout('layout/cmslayout.phtml');
   // \Zend\EventManager\StaticEventManager::resetInstance();
    // echo  $this->company->getUser()->getName();
    //  $adapter = $this->company->getUser()->getInstance();
     /*
      if(!$this->company->getUser()->isLoggedIn()) {
        $user = 'davido';
        $pass = 'dailer00';
        \Zend\Debug::dump($this->company->getUser()->authenticate($user, $pass));
      } else {
          \Zend\Debug::dump($this->company->getUser()->getUserInfo());
      }
      $this->company->getUser()->logout();
     */
   //\Zend\Debug::dump($this->company->getUser()->getUserInfo());
     
      /*
      $select = $db->select()
                            ->from(array('c' => 'prodcat'),
                                    array('descr'))
                            ->join(array('p' => 'products'),
                                    'p.prodcat = c.id',
                                    array('id', 'prodcat', 'description', 'retail_price', 'photo'))
                            ->where('visible = ?', "1")
                            ->order('RAND()');
          //  echo $select->__toString();exit;
       $products = $db->fetchAll($select);
            var_dump($products);
      */
    //  $adapter = $this->company->getUser();
      
     // $attempts = $adapter->checkLoginCount();
      
     // if($attempts > $this->config->allowedFailedLoginAttempts)
      //    echo 'hit';
   /*   
     $cart= array('lollies'=>array('qty'=>4,
                                    'cost'=>10,
                                    ),
                  'chicken' =>array('qty' => 20,
                                   'cost' => 15, 
                      ),                  
         );
      */
     // $storage->fromArray($cart);
   // echo  $this->company->getSession()->getName(); //destroy();
     // echo offoffset$storage->offsetGet('david2');
    //  $this->company->getSession()->writeClose();/*
   /*   if($cartSet = $storage->offsetGet('cart')) {
          $cartSet = array_merge($cartSet,$cart);
           $storage->offsetSet('cart', $cartSet);
      } else {
          $this->company->getSession()->offsetSet('message', 'Not foubd);
           $storage->offsetSet('cart', $cart);
      }
      */
     // var_dump($storage->offsetGet('cart'));
    // $app = $events->getParam('application');
    // $this->setEvent($e);
     // \Zend\Debug::dump($this->company->getInstance());
    //  echo 'test';
     // $this->attachDefaultListeners();
     //$form = new LoginForm();
    //$form->submit->setLabel('Login');

  
      // $db = $this->locator->get('Db');
      // $log = new \Infosys\Log\Log($db, $this->events);
       //var_dump($db);
     //  InfosysLog::attachEvents($db);
       
      // InfosysLog::addLog('Testing static usage what will happen');
       //$mail = $this->locator->get('mail');
      // $mail->sendMail('<b>hi there</b> <br> Come to my party<br /> regards <br /> me');
       

     // $this->company->getSession()->setKey('message', array('type' => 'message',  'message' =>'Not found here please try again later'));
    // $userSession = $this->locator->get('userSessionManager');
      
    //  $lan =  $this->locator->get('translator');
      
    //  var_dump($lan->_('login','st'));
    //  exit;
    /* 
     $data = array('data' => '{"user:"david,"admin":"true"}',
                    'userid' => 43,
                    'clientid' => 1,
                    'guest' => 0,
                    'username' =>'davido',
                );
    //$userSession->write(session_id(),$data);
   //exit;  
     */
     
       // $user = 'davido';
       // $pass = 'dailer00';
       // $this->company->getUser()->authenticate($user, $pass);
       // $this->company->getUser()->logout();
        
       ////////////////////////////////////////////////////////////////////////////////


/**
 * Generate HTML for multi-dimensional menu from MySQL database
 * with ONE QUERY and WITHOUT RECURSION 
 * @author J. Bruni
 */
class MenuBuilder
{
	/**
	 * MySQL connection
	 */
	var $conn;
	
	/**
	 * Menu items
	 */
	var $items = array();
	
	/**
	 * HTML contents
	 */
	var $html  = array();
	
	
	
	/**
	 * Build the HTML for the menu 
	 */
	function get_menu_html( $root_id = 0 )
	{
		$this->html  = array();
		$this->items = $this->get_menu_items();
		
		foreach ( $this->items as $item )
			$children[$item['parent_id']][] = $item;
		
		// loop will be false if the root has no children (i.e., an empty menu!)
		$loop = !empty( $children[$root_id] );
		
		// initializing $parent as the root
		$parent = $root_id;
		$parent_stack = array();
		
		// HTML wrapper for the menu (open)
		$this->html[] = '<ul>';
		
		while ( $loop && ( ( $option = each( $children[$parent] ) ) || ( $parent > $root_id ) ) )
		{
			if ( $option === false )
			{
				$parent = array_pop( $parent_stack );
				
				// HTML for menu item containing childrens (close)
				$this->html[] = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 ) . '</ul>';
				$this->html[] = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ) . '</li>';
			}
			elseif ( !empty( $children[$option['value']['id']] ) )
			{
				$tab = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 );
				
				// HTML for menu item containing childrens (open)
				$this->html[] = sprintf(
					'%1$s<li><a href="%2$s">%3$s</a>',
					$tab,   // %1$s = tabulation
					$option['value']['link'],   // %2$s = link (URL)
					$option['value']['title']   // %3$s = title
				); 
				$this->html[] = $tab . "\t" . '<ul class="submenu">';
				
				array_push( $parent_stack, $option['value']['parent_id'] );
				$parent = $option['value']['id'];
			}
			else
				// HTML for menu item with no children (aka "leaf") 
				$this->html[] = sprintf(
					'%1$s<li><a href="%2$s">%3$s</a></li>',
					str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ),   // %1$s = tabulation
					$option['value']['link'],   // %2$s = link (URL)
					$option['value']['title']   // %3$s = title
				);
		}
		
		// HTML wrapper for the menu (close)
		$this->html[] = '</ul>';
		
		return implode( "\r\n", $this->html );
	}
} 
        