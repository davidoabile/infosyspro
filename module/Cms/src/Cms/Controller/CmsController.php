<?php

namespace Cms\Controller;

use Infosyspro\Traits\QuickSQL;

class CmsController extends ActionController {

    protected $config = null;
    protected $lang;
    protected $sqlBase = null;
    protected $output = '';
    protected $permDenied = '';
    protected $currentlang;
    protected $user = null;

    protected function init() {
        $this->lang = $this->locator->get('translator');
        $this->user = $this->company->getUsers();

        if ($this->request->getRequestUri() !== '/cms' && !$this->request->query()->get('auth')) {
            if (!$this->user->isLoggedIn()) {
               echo $this->company->getOffice()->loadUser();                
                exit;
            } 
        }
    }

    public function indexAction() {

        $this->company->setPageTitle($this->lang->translate('contentManagement'));
        $USER = $this->company->getUsers();
        $attempts = $USER->checkLoginCount();

        //$this->company->getSession()->setKey('message', array('type' => 'message',  'message' =>'Not found here please try again later'));
        // $userSession = $this->locator->get('userSessionManager');
        // $lan =  $this->locator->get('translator');
        // var_dump($this->config);
        // $this->config->mail->sentFromName;
        // exit;
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
        //if ($attempts > $this->config->allowedFailedLoginAttempts)
        //    echo 'hit';
/*
        $results = array('company' => $this->config->company,
            'allowedFailedLoginValue' => $this->config->allowedFailedLoginAttempts,
            'maxLockoutTime' => $this->config->maximumLockOutFailedLoginAttemptsTime,
            'attempts' => $attempts,
                );
 * 
 */
       //  echo '{ "success": true, "msg": "Logged in" }';
    }

    public function cpanelAction() {
        $response = '{ "success": false, "msg": "Something went wrong" }';
        // $this->company->getSession()->setKey('message', array('type' => 'message',  'message' =>'Not found here please try again later'));
        $request = $this->getRequest();
        $postdata = $request->post()->toArray();
        //$message = new MessageQueue($this->locator);

        if ($request->isPost()) {
            $response = '{ "success": true, "msg": [' . json_encode($postdata) . '] }';
        }

        echo $response;
        exit;

        return array();
    }

    public function createArticleAction() {
        /*
          $broker = $this->locator->get('cmsHelper');
          \Zend\Dojo\Dojo:: enableView($this->view);
          $form = $broker->load('TinyMceForm', array('name' => 'fulltext',
          'id' => 'iform_articletext',
          'required' => true,
          'class' => 'mce_editable',
          'value' => '',
          ));
         * 
         */


        return array('contentType' => 'article');
    }

    

    public function getList($query) {

        //Expects a name spaced method NAMESPACE_CLASSFOLDER_CLASSNAME
       // $classLocation = explode('_', $query['object']);
              
            if (!empty($query['object'])) {
                
                 $classMethod = explode('_', $query['object']);
            
                     $object = 'get' . $classMethod[0];   
            
                if (method_exists($this->company, $object)) {
                    unset($query['object']);
                    $query['method'] = lcfirst($classMethod[1]);
                    
                    $result = $this->company->$object()->getList($query);
                }
           
                echo $this->_response($result);
                
                
            } else {

            $confSql = $this->sqlBase['Tb' . $query['router']];
            //TODO: add acl here
            //if($confSql['default']['acl'] == 'guest') {    		
            $sql = $confSql['default']['sql'];
            //  }

            $limit = ((int) $query['limit'] > 0 ) ? $query['limit'] : 20;
            $start = ((int) $query['start'] > -1 ) ? $query['start'] : 0;
            $order = ' ORDER BY ' . $query['sort'] . ' ' . $query['dir'];

            $sql = $sql . $order . ' LIMIT ' . $start . ' , ' . $limit;
            echo $this->_reader($sql);
        }
        return $this->getResponse();
    }

    /**
     * Return single resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function get($id, $query) {

        if (!$id) {
            echo $this->output;
        } else {
            //Expects a name spaced method CLASSNAME 
                   
            if (!empty($query['object'])) {
                $result = null;
                
                 $classMethod = explode('_', $query['object']);
            
                     $object = 'get' . $classMethod[0];   
            
                if (method_exists($this->company, $object)) {
                    unset($query['object']);
                    $query['method'] = lcfirst($classMethod[1]);
                    
                    $result = $this->company->$object()->get($query['id'], $query);
                }
                
                echo $this->_response($result);
                
                
            } else {
                
                //If we just want to use stored SQL then let's do it
                
                 $confSql = $this->sqlBase['Tb' . $query['router']];
                //TODO: add acl here
               
                // if($confSql['custom']['acl'] == 'guest') {
                $sql = str_replace('[id]', $id, $confSql['custom']['sql']);
                $limit = ((int) $query['limit'] > 0 ) ? $query['limit'] : 20;
                $start = ((int) $query['start'] > -1 ) ? $query['start'] : 0;
                $order = ' ORDER BY ' . $query['sort'] . ' ' . $query['dir'];

                $sql = $sql . $order . ' LIMIT ' . $start . ' , ' . $limit;
                echo $this->_reader($sql);
            }
        }
        return $this->getResponse();
    }

    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data) {

        if (count($data) < 1) {
            $data = $GLOBALS['HTTP_RAW_POST_DATA'];
        }

        //Expects a name spaced method NAMESPACE_CLASSFOLDER_CLASSNAME
        $classLocation = explode('_', $data['object']);
        if (sizeof($classLocation) == 4) {
            $result = '';
            $object = null;
            $class = $classLocation[0] . '\\' . $classLocation[1] . '\\' . $classLocation[2];

            if (class_exists($class)) {
                if ($classLocation[1] === 'User') {
                    $object = $this->user;
                } else {
                    $object = new $class($this->locator);
                }

                $result = $object->create($data);
            }
            echo $this->_response($result);
        }

        return $this->getResponse();
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data) {
        var_dump($data);
        return $this->getResponse();
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id, $data) {
        $table = $data['router'];
        if (count($data) < 1 || !empty($data['_dc'])) {
            //$data = $GLOBALS['HTTP_RAW_POST_DATA'];    		
            $data = file_get_contents("php://input");
            $data = json_decode($data, true);
            //parse_str($input, $data);
        }

        //$data = $GLOBALS['HTTP_RAW_POST_DATA'];
        //var_dump($data);exit;
        $this->_delete($data, $table);

        return $this->getResponse();
    }

    
    /**
     * Update records in the database populated by the CMS
     * 
     * @param json object $postdata
     * @param string $tableName
     * @return string 
     */
    protected function _update($postdata, $tableName) {
        //msg if all went bad
        $response = '{
                        "success": false,  "type" : "ext-mb-error",                       
                        "message": " ' . $this->lang->translate('failedToUpdateRecords') . ' "
                     }';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postdata = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
            $table = $this->locator->get('Dbtable');
            $table->setOptions(array('name' => $postdata, $tableName));
            $i = 0;
            $j = 0;

            //Delete records from the database
            foreach ($postdata as $data) {
                try {
                    $where = $table->getAdapter()->quoteInto('id = ?', $data->id);
                    unset($data->id);
                    if ($table->update($data, $where))
                        $i++;
                    else
                        $j++;
                } catch (\Exception $e) {
                    $j++;
                    continue;
                }
            }

            if ($i > 0 && $j == 0) {
                $response = '{
                             "success": true, "type" : "ext-mb-info",                              
                             "message": ' . json_encode($i . ' ' . $this->lang->translate('recordsUpdatedSuccessfully')) . ' 
                            }';
            } elseif ($j > 0) {
                $response = '{
                            "success": true,  "type" : "ext-mb-info",                             
                            "message": ' . json_encode($i . ' ' . $this->lang->translate('recordsUpdatedSuccessfully') . '<br /> ' .
                                $j . ' ' . $this->lang->translate('recordsFailed')) . ' 
                        }';
            }
        }
        return $response;
    }

    protected function _delete($data, $table) {
        //msg if all went bad
        $response = '{
                        "success": false,   "type" : "ext-mb-error",                      
                        "message": " ' . $this->lang->translate('failedToDeleteRecords') . ' "
                     }';

        if (!(int) $data['id']) {
            return $response;
        }
        $adapter = $this->locator->get('Db');
        $sql = 'DELETE FROM Tb' . $table . ' WHERE id=' . (int) $data['id'];

        if (QuickSQL::delete($sql, $adapter)) {
            $response = '{
                             "success": true, "type" : "ext-mb-info",                              
                             "message": ' . json_encode($this->lang->translate('recordsRemovedSuccessfully')) . ' 
                            }';
        }

        return $response;
    }

    protected function _reader($sql) {
        $data = '';

        if (empty($sql))
            return $response;

        $adapter = $this->locator->get('Db');
        QuickSQL::processQuery($sql, $adapter);
        $total = QuickSQL::getCount();
        if ($total > 0) {
            $data = '{
                            "success": true,
                            "total": ' . $total . ',
                            "articles":  ' . json_encode(QuickSQL::getResults()) . '  
                        }';
        }

        return $this->_response($data);
    }

    /**
     * This is just a response object
     * 
     * @param mixture $data 
     */
    protected function _response($data) {
       
         $response = '{ "success": false, "data" : "[]" , "error": {"title" : "No data Found", "message" : ' . json_encode($this->lang->translate('errorNoDataFound')) . '}}';

        if (!empty($data)) {
            if (is_array($data) || is_object($data)) {
                $data = json_encode($data);
            }
            $response = $data;
        }
        return $response;
    }

  
    protected function _loadJson($data) {

        $datastring = $data['lan'];
        $regexes = array(
            array("p" => "/[\w]*(\/\/).*$/m", "r" => ""), //remove comments
            array("p" => "/'/m", "r" => "\"")  //replace single-quotes with double-quotes
                );

        foreach ($regexes as $regex) {
            $datastring = preg_replace($regex['p'], $regex['r'], $datastring);
        }
        preg_match("/Desktop[ ]?=[ ]?\{([^\;]+)\\;/", $datastring, $matches);

        $res = json_decode('{' . $datastring, true);

        return $res;
    }

}

