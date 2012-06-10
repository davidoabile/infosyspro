<?php
 namespace Infosyspro\SoapServer;
 class SoapServer 
 {
    /**
     * @var The locator object 
     */
    protected $locator;
   
    /**
     * @var The user object
     */
    protected $user;
     
    /**
     *
     * @param array $options 
     */
     public function __construct($options)
     {
         $this->locator = $options['locator'];        
         $this->user = $this->locator->get('userBase');
         $this->table = $this->locator->get('Dbtable');
     }
     /**
      * Get a section of a particular module or Controller configurations from the DB
      * 
      * @return object Zend\Config
      */
     public function getConfig($where)
     {
		//TODO: verify company before executing the query
         return  $this->locator->get('appConfig')->loadDbConfig($where);
     }

     /**
      * The method will send back what i have asked
      * 
      * @param string $username
      * @param string $password
      * @return object
      */
     public function authenticate($username='', $password)
     {     
        $this->user->setLocator( $this->locator );
        if(!$this->user->isLoggedIn()) {           
           $res = $this->user->authenticate($username, $password);
        } 
      
       return $this->user->isLoggedIn();
     }

     /**
      * Check if we have reached the ...
      * 
      * @return int
      */
     public function test() 
     {
         // $this->user->setLocator( $this->locator );
         return $this->user->checkLoginCount();
     }
 }

 