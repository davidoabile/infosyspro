<?php

 namespace Application\View;

use ArrayAccess,
    
    Zend\EventManager\EventCollection,
    Zend\EventManager\EventManagerInterface,
    Zend\EventManager\StaticEventManager,
    Zend\Http\PhpEnvironment\Response,
    Zend\View\Model\ViewModel,
    Zend\View\Renderer\PhpRenderer,
    Zend\Mvc\Application,
    Zend\Mvc\MvcEvent,
    Zend\View\Renderer;

 class Listener implements \Zend\EventManager\ListenerAggregateInterface
 {

     protected $layout;
     protected $listeners = array();
     protected $staticListeners = array();
     protected $view;
     protected $displayExceptions = true;
     protected $template;
     protected $locator = null;
     protected $templateTags = array();
     protected $menuid;
     protected $renderer = null;

     public function __construct(PhpRenderer $renderer, $layout = 'layout.phtml')
     {
         $this->view = $renderer;
         $this->layout = $layout;
         
     }

     public function setDisplayExceptionsFlag($flag)
     {
         $this->displayExceptions = (bool) $flag;
         return $this;
     }

     public function displayExceptions()
     {
         return $this->displayExceptions;
     }

     public function attach(EventManagerInterface $events)
     {
         
        $this->listeners[] = $events->attach('dispatch.error', array($this, 'renderError'));
    //   $this->listeners[] = $events->attach('dispatch', array($this, 'render404'), 10);
        $this->listeners[] = $events->attach('dispatch', array($this, 'renderLayout'), -50);
     }

     public function detach(EventManagerInterface $events)
     {
         foreach ($this->listeners as $key => $listener) {
             $events->detach($listener);
             unset($this->listeners[$key]);
             unset($listener);
         }
     }

     public function registerStaticListeners(StaticEventManager $events, $locator)
     {
         $this->locator = $locator;
         $ident = 'Zend\Mvc\Controller\ActionController';
         $handler = $events->attach($ident, 'dispatch', array($this, 'renderView'));
         $this->staticListeners[] = array($ident, $handler);
         
       //  $this->renderer = new PhpRenderer();
         //$this->renderer->setResolver($this->locator->get('Zend\View\Resolver\TemplatePathStack'));
         
     }

     public function detachStaticListeners(StaticEventMAnager $events)
     {
         foreach ($this->staticListeners as $i => $info) {
             list($id, $handler) = $info;
             $events->detach($id, $handler);
             unset($this->staticListeners[$i]);
         }
     }

     public function renderView(MvcEvent $e)
     {
         $response = $e->getResponse();
         if (!$response->isSuccess()) {
             return;
         }

         $routeMatch = $e->getRouteMatch();
         $controller = $routeMatch->getParam('controller', 'index');
         $id = $routeMatch->getParam('id', '');
         $dynamicAction = $routeMatch->getMatchedRouteName();
         
         
         if($dynamicAction != 'default') {
             $controller = strtolower(
                                        rtrim(
                                               array_pop(
                                                            explode('\\' , $controller)
                                                ), 
                                         'Controller')
                     );
      
         }
       
         //Get the matched route name. this is maybe used for routing blogs, news.rss etc 
       if($id) {
           
           $action = $id;
       } else {        
           $action = $routeMatch->getParam('action', 'index');
       }
         
          
         $this->menuid = lcfirst($controller) . ucfirst(str_replace(array('.html', '-', '_'), '', $action));

         if ($id) {
             $action = 'index';
         }
         
         
         $script = $controller . '/' . $action ;

         $vars = $e->getResult();
       
         if (is_scalar($vars)) {
             $vars = array('content' => $vars);
         } elseif (is_object($vars) && !$vars instanceof ArrayAccess) {
             $vars = (array) $vars;
         }
 
         $content = $this->view->render($script, $vars);

         $e->setParam('content', $content);

         return $content;
     }

     public function renderLayout(MvcEvent $e, $layout = '')
     {
        
         $layout = (!empty($layout) ? $layout : $this->layout);
        
         $response = $e->getResponse();
         if (!$response) {
             return;
             $response = new Response();
             $e->setResponse($response);
         }
         if ($response->isRedirect()) {
             return $response;
         }
    
         if($e->getError()) {
            $layout = 'layouts/error';
            $content = $e->getResult();
         } else {
              $model = $e->getResult();

         if (false !== ($contentParam = $e->getParam('content', false))) {
             $model->setVariable('content', $contentParam );
      //         var_dump($vars); exit;
         }  
     
            $model->setTemplate($layout);
            $contents = $this->view->render($model);

            $this->template = $contents;
            /* now it time to process the odoc function*/
            $this->parseTemplate();
            $content = $this->render();
         }
       
         //inject the result into the response object
         $response->setContent($content);
         $e->stopPropagation();
         return $response;
     }

     public function render404(MvcEvent $e)
     {

         $vars = $e->getResult();
         if ($vars instanceof Response) {
             return;
         }

         $response = $e->getResponse();
         if ($response->getStatusCode() != 404) {
             // Only handle 404's
             return;
         }

       
        $e->stopPropagation();
        return $response;
     }

     public function renderError(MvcEvent $e)
     {

         $error = $e->getError();
         $app = $e->getTarget();
        // $matches = $e->getRouteMatch();
        // $renderer = $locator->get('view');
         $response = $e->getResponse();
         if (!$response) {
             $response = new Response();
             $e->setResponse($response);
         }

         switch ($error) {
             case Application::ERROR_CONTROLLER_NOT_FOUND:
             case Application::ERROR_CONTROLLER_INVALID:
                 $vars = array(
                     'message' => 'Page not found.',
                     'exception' => $e->getParam('exception'),
                     'display_exceptions' => $this->displayExceptions(),
                 );
                 $response->setStatusCode(404);
                 break;

             case Application::ERROR_EXCEPTION:
             default:
                 $exception = $e->getParam('exception');
                 $vars = array(
                     'message' => 'An error occurred during execution; please try again later.',
                     'exception' => $e->getParam('exception'),
                     'display_exceptions' => $this->displayExceptions(),
                 );
                 $response->setStatusCode(500);
                 break;
         }
//\Zend\Debug::dump($vars); exit;
         
         //$view = new ViewModel($vars);
       
       // $view->setTemplate('error/index');
        $content = $this->view->render('error/index', $vars);
       //var_dump($content); exit;
        
        // $content = $view->setTemplate('bar/do-something')$this->view->render('error/index.phtml', $vars);

         $e->setResult($content);
        $this->renderLayout($e, 'layouts/layout');       
         return $response;
     }

     /**
      * Get the contents of a document include
      *
      * @param   string  $type     The type of renderer
      * @param   string  $name     The name of the element to render
      * @param   array   $attribs  Associative array of remaining attributes.
      *
      * @return  The output of the renderer
      *
      * @since   11.1
      */
     public function getBuffer($type = null, $name = null, $attribs = array())
     {
         // If no type is specified, return the whole buffer
         if ($type === null) {
             return;
         }

         $result = null;
         //var_dump($attribs); exit;
         $renderer = $this->loadRenderer($type, $name);
         if (is_object($renderer)) {
             $contents = $renderer->render($attribs);
         } else {
             return $renderer;
         }

         return $contents;
         //return self::$_buffer[$type][$name];
     }

     /**
      * Outputs the template to the browser.
      *
      * @param   boolean  $cache   If true, cache the output
      * @param   array    $params  Associative array of attributes
      *
      * @return  The rendered data
      *
      * @since   11.1
      */
     public function render($caching = false, $params = array())
     {
         $this->_caching = $caching;

         if (!empty($this->_template)) {
             $data = $this->renderTemplate();
         } else {
             //$this->parse($params);
             $data = $this->renderTemplate();
         }

         return $data;
     }

     /**
      * Load a renderer
      *
      * @param   string  $type  The renderer type
      *
      * @return  mixed  Object or null if class does not exist
      * @since   11.1
      */
     protected function loadRenderer($type, $class, $namespace = 'Infosyspro')
     {
         $class = $namespace . '\\' . $type . '\\' . $class;
         if (!class_exists($class)) {
             return null;
         }
         $instance = new $class($this->locator->get('companylib'), $this->menuid);

         return $instance;
     }

     /**
      * Parse a document template
      *
      * @return  The parsed contents of the template
      *
      * @since   11.1
      */
     protected function parseTemplate()
     {
         $matches = array();

         if (preg_match_all('#<odoc:include\ type="([^"]+)" (.*)\/>#iU', $this->template, $matches)) {
             $template_tags_first = array();
             $template_tags_last = array();

             // Step through the jdocs in reverse order.
             for ($i = count($matches[0]) - 1; $i >= 0; $i--) {
                 $type = $matches[1][$i];
                 $attribs = empty($matches[2][$i]) ? array() : $this->parseAttributes($matches[2][$i]);
                 $name = isset($attribs['name']) ? $attribs['name'] : null;

                 // Separate buffers to be executed first and last
                 if ($type == 'sticky' || $type == 'stickies') {
                     $template_tags_first[$matches[0][$i]] = array('type' => $type, 'name' => $name, 'attribs' => $attribs);
                 } else {
                     $template_tags_last[$matches[0][$i]] = array('type' => $type, 'name' => $name, 'attribs' => $attribs);
                 }
             }
             // Reverse the last array so the jdocs are in forward order.
             $template_tags_last = array_reverse($template_tags_last);

             $this->templateTags = $template_tags_first + $template_tags_last;
             //  var_dump($this->templateTags);exit;
         }
     }

     /**
      * Render pre-parsed template
      *
      * @return string rendered template
      *
      * @since   11.1
      */
     protected function renderTemplate()
     {
         $replace = array();
         $with = array();

         foreach ($this->templateTags as $odoc => $args) {
             $replace[] = $odoc;
             $with[] = $this->getBuffer($args['type'], $args['name'], $args['attribs']);
         }

         return str_replace($replace, $with, $this->template);
     }

     /**
      * Method to extract key/value pairs out of a string with XML style attributes
      *
      * @param   string  $string  String containing XML style attributes
      *
      * @return  array   Key/Value pairs for the attributes
      * @since       11.1
      */
     protected function parseAttributes($string)
     {
         // Initialise variables.
         $attr = array();
         $retarray = array();

         // Let's grab all the key/value pairs using a regular expression
         preg_match_all('/([\w:-]+)[\s]?=[\s]?"([^"]*)"/i', $string, $attr);

         if (is_array($attr)) {
             $numPairs = count($attr[1]);
             for ($i = 0; $i < $numPairs; $i++) {
                 $retarray[$attr[1][$i]] = $attr[2][$i];
             }
         }

         return $retarray;
     }

 }