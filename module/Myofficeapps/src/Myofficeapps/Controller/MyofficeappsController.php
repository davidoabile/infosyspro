<?php

namespace Myofficeapps\Controller;

use Infosyspro\Traits\QuickSQL;

class MyofficeappsController extends ActionController {

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

        if ($this->request->getRequestUri() !== '/myofficeapps' && !$this->request->query()->get('auth')) {
            if (!$this->user->isLoggedIn()) {
                 $this->_response($this->company->getOffice()->loadUser());
     
            }
        }
    }

    public function indexAction() {

        return ;  
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

            return $this->_response($result);
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
            return $this->_reader($sql);
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

                return $this->_response($result);
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
                return $this->_reader($sql);
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
     * Update records in the database populated by the myofficeapps
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

   

    /**
     * This is just a Json response object
     * 
     * @param mixture $data 
     */
    protected function _response($data) {
            if (!empty($data)) {
                $response = $data;
                
            } else {
                
                $response =  array ( 'success' => false, 
                             'data'  => '[]' , 
                             'error' => array ( 'title'  => $this->lang->translate('noDataFound') ,
                                                'message' => $this->lang->translate('errorNoDataFound')
                                               ),
                );
        
            }
  
         $view = new \Zend\View\Model\ViewModel(array(
            'data' => $response,
        ));
         // We'll be outputting a Json
        header('Content-type: application/json');
        // Disable layouts; use this view model in the MVC event instead
        $view->setTerminal(true);
        return $view;
    }

}

