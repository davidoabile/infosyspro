<?php

namespace Cms\Controller;

use Infosyspro\SoapServer\SoapServer,
    Infosyspro\Sticky\MessageQueue,
    Zend\View\Model\ViewModel,
        Infosyspro\Traits\QuickSQL;

class CmsController extends ActionController {

   
    protected $config = null;
    protected $lang;

    protected $currentlang;

    protected function init() {

        $config = $this->locator->get('appConfig');
        $where = array('where' => array('moduleName' => 'formData'),
            'orWhere' => array('moduleName' => 'site'),
        );
        $this->view = $this->locator->get('view');
        $this->company = $this->locator->get('companylib');
        $this->lang = $this->locator->get('translator');
        $this->currentlang = $this->lang->getLocale();
        $this->config = $config->loadDbConfig($where);
        // $SoapClient = $this->locator->get('soapClient');
    }

    public function indexAction() {

        $this->company->setPageTitle($this->lang->translate('contentManagement'));
        $USER = $this->company->getUser();
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

        $results = array('company' => $this->config->company,
            'allowedFailedLoginValue' => $this->config->allowedFailedLoginAttempts,
            'maxLockoutTime' => $this->config->maximumLockOutFailedLoginAttemptsTime,
            'attempts' => $attempts,
        );
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

    public function editAction() {
        $response = '{ success: false, errorMessage: "Article or Blog not found" }';
        $id = '1';
        $this->table->setOptions(array('name' => 'TbContent'));
        //$this->table->setFetchMode(\Zend\Db\Db::FETCH_ASSOC);
        $data = $this->table->select()
                ->where('id = ?', $id);
        $content = $this->table->fetchRow($data);

        $metadata = json_decode($content->metadata);
        $attribs = json_decode($content->attribs, true);
        $params = array();
        foreach ($attribs as $k => $v) {
            $params['ioptions[' . $k . ']'] = $v;
        }
        unset($content->metadata);
        unset($content->attribs);

        $data = $content->toArray();
        $data = array_merge($data, $params);
        //$content->metadata = $metadata;
        // var_dump($data);
        if ($content) {
            $response = '{
                        success: true,
                        data: ' . json_encode($data) . '
                        }';
        }
        echo $response;
        exit;
        // return $this->getResponse();
    }

    public function createblogAction() {

        $broker = $this->locator->get('cmsHelper');

        $form = $broker->load('TinyMceForm', array('name' => 'fulltext',
            'id' => 'iform_articletext',
            'required' => true,
            'class' => 'mce_editable',
            'value' => '',
                ));


        return array('form' => $form);
    }

    /**
     *  Process the edit and create action
     */
    public function processAction() {
        $request = $this->getRequest();
        $postdata = $request->post()->toArray();
        //$message = new MessageQueue($this->locator);
        $response = '{ "success": false, "msg": {"type" : "ext-mb-error", "message" : ' . json_encode($this->lang->translate('errorFailedTosaveData')) . '}}';
        if ($request->isPost()) {
            $this->table->setOptions(array('name' => 'TbContent'));
            // $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => sprintf($this->lang->translate('errorIncorrectData'), 'category')));
            //  $msg = $message->init();
            if (empty($postdata['title']) || empty($postdata['fulltext'])) {
                $response = '{ "success": false, "msg": {"type" : "ext-mb-error", "message" : ' . json_encode($this->lang->translate('titleAndContentCannotBeEmpty')) . '}}';
                // $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => $this->lang->translate('titleAndContentCannotBeEmpty')));
            } else {
                $postdata['attribs'] = json_encode($postdata['ioptions']);
                unset($postdata['ioptions']);
                //$postdata['metadata'] = json_encode($postdata['metadata']);
                // Check if we need to update
                if (!empty($postdata['id'])) {
                    $postdata['modified'] = new \Zend\Db\Expr('CURDATE()');
                    $where = $this->table->getAdapter()->quoteInto('id = ?', $postdata['id']);
                    try {
                        $this->table->update($postdata, $where);
                        $response = '{ "success": true, "msg": {"type" : "ext-mb-info", "message" : ' . json_encode($this->lang->translate('dataUpdatedSuccessfully')) . '}}';
                        //  $this->company->getSession()->setKey('message', array('type' => 'message', 'message' => $this->lang->translate('dataUpdatedSuccessfully')));
                    } catch (\Exception $e) {
                        $response = '{ "success": false, "msg": {"type" : "ext-mb-error", "message" : ' . json_encode($this->lang->translate('errorFailedTosaveData')) . '}}';
                        //$this->company->getSession()->setKey('message', array('type' => 'error', 'message' => $this->lang->translate('errorFailedTosaveData')));
                    }
                } else {
                    $postdata['created'] = new \Zend\Db\Expr('CURDATE()');
                    $postdata['alias'] = strtolower(str_replace(' ', '-', $postdata['title']));

                    try {
                        $this->table->insert($postdata);
                        $response = '{ "success": true, "msg": {"type" : "ext-mb-info", "message" : ' . json_encode($this->lang->translate('dataSavedSuccessfully')) . '}}';
                        //$this->company->getSession()->setKey('message', array('type' => 'message', 'message' => $this->lang->translate('dataSavedSuccessfully')));
                    } catch (\Exception $e) {
                        trigger_error($e, E_USER_ERROR);
                        // $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => $this->lang->translate('errorFailedTosaveData')));
                        $response = '{ "success": false, "msg": {"type" : "ext-mb-error", "message" : ' . json_encode($this->lang->translate('errorFailedTosaveDataHere')) . '}}';
                    }
                }
            }
            // unset($postdata['metadata']);
            // var_dump($postdata);
        }
        echo $response;
        return $this->getResponse();
    }

    public function configAction() {
        $request = $this->getRequest();
        $error = false;

        // $this->company->getSession()->setKey('lang','en');
        if ($request->isPost()) {
            if ($request->post()->get('iform', false)) {

                $postdata = $request->post()->toArray();
                // $validator = new \Zend\Validator\Alnum();
                //  $validator2 = new \Zend\Validator\Alnum(array('allowWhiteSpace' => true));
                $form = array();

                $num = 0;
                if (!empty($postdata['iform']['config_key'][2])) {
                    $num = 2;
                } elseif (!empty($postdata['iform']['config_key'][1])) {
                    $num = 1;
                }


                for ($i = 0; $i <= $num; $i++) {
                    $v = $i + 1;
                    $data['key'] = $postdata['iform']['config_key'][$i];

                    // if (!$validator->isValid($data['key'])) {
                    //     $error = true;
                    //     $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => sprintf($this->lang->translate('errorIncorrectData'), 'category'. $v)));
                    //     break;
                    // }
                    $data['value'] = $postdata['iform']['config_value'][$i];

                    /* if (!$validator->isValid($data['value'])) {
                      $error = true;
                      $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => 'Incorrect data detected in value' . $v));
                      break;
                      }
                     */
                    $data['langid'] = $postdata['iform']['config_language'][$i];
                    $data['description'] = $postdata['iform']['config_description'][$i];
                    // if (!$validator2->isValid($data['description'])) {
                    //    $error = true;
                    //    $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => sprintf($this->lang->translate('errorIncorrectData'), 'category'. $v)));
                    //     break;
                    // }

                    $data['moduleName'] = $postdata['iform']['config_category'][$i];
                    // if (!$validator->isValid($data['moduleName'])) {
                    //      $error = true;
                    //      $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => sprintf($this->lang->translate('errorIncorrectData'), 'category'. $v)));
                    //    break;
                    //   }

                    $form[] = $data;
                }
                if (!$error && sizeof($form) > 0) {
                    $table = $this->locator->get('Dbtable');
                    $table->setOptions(array('name' => 'TbConfig'));
                    foreach ($form as $v) {
                        if (!$table->insert($v)) {
                            $this->company->getSession()->setKey('message', array('type' => 'error', 'message' => $this->lang->translate('failedInsertData')));
                            $error = true;
                            break;
                        }
                    }

                    if (!$error) {
                        $this->company->getSession()->setKey('message', array('type' => 'message', 'message' => $this->lang->translate('newConfigurationAdded')));
                    }
                }
            }
        }
        $configs = $this->locator->get('appConfig');
        $config = $configs->loadDbConfig();
        $this->company->setHeadScript('appendFile', array('/media/cms/js/system/switcher.js'));
        return array('config' => $config, 'lang' => $this->lang);
    }

    public function ArticleReaderAction() {
       $query = $this->getRequest()->query()->toArray();
       $limit = ((int)$query['limit'] > 0 ) ?  $query['limit'] : 20;
       $start = ((int)$query['start'] > -1 ) ? $query['start'] : 0; 
       $order =  ' ORDER BY ' . $query['sort'] . ' ' . $query['dir'];
              
        $sql = 'SELECT id, title, alias, content_type, published, created, ordering, hits 
                FROM TbContent WHERE published = 1 ' . $order . 
                ' LIMIT ' . $start . ',' . $limit;    
         
        echo $this->_reader($sql);
        return $this->getResponse();
    }

    public function ArticleDestroyerAction() {
        echo $this->_delete(json_decode($GLOBALS['HTTP_RAW_POST_DATA']), 'TbContent');
        return $this->getResponse();
    }

    public function ArticleUpdatorAction() {
        echo $this->_create(json_decode($GLOBALS['HTTP_RAW_POST_DATA']), 'TbContent');
        return $this->getResponSe();
    }

    public function ArticleCreatorAction() {
       /*  $query = $this->getRequest()->query()->toArray();
       ->limit($query['limit'], $query['start'])
                ->order($query['sort'] . ' ' . $query['dir']);
       
       */
       
        echo $this->_create(json_decode($GLOBALS['HTTP_RAW_POST_DATA']), 'TbContent');
        exit;
    }

    public function phpinfoAction() {
        phpinfo();
        return $this->getResponse();
    }

    public function getTreeAction() {
        $tableName = 'tree';
        $db = $this->locator->get('Db');
        // $table->setOptions(array('name' => $tableName));
        //        echo json_encode($otree->getTree());
        $sql = "SELECT node.id,node.text,node.lft,node.rt,
                (SELECT COUNT(*) FROM tree AS parent WHERE parent.lft < node.lft AND parent.rt > node.rt) depth,
            (node.rt-node.lft-1)/2 childNodes FROM tree AS node ORDER BY node.lft ASC";

        $stmt = $db->query($sql);
        $stmt->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $trees = $stmt->fetchAll();
        $tree = array();
        $nextDepth = 0;
        $children = array();
        
        $tt = count($trees) - 1;
        $currDepth = 0;
         $str = '[';
         
        foreach ($trees as $child => $node) {
/*
            if ($child < $tt) {
                if ($child == 0) {
                    $tree[$child] = array('id' => $node->id,
                        'text' => $node->text,
                        'leaf' => 'true',
                        'children' => '[]'
                    );
                }

                $nextDepth = $trees[$child + 1]->depth;
               // continue;
            } else {
                $nextDepth = 0;
            }
            //get Child nodes
            $babies = array();
            if($child > 0) {
            if ( $nextDepth > $node->depth && $currDepth == 0 && $child > 0) {
                $children[$child] = array('id' => $node->id,
                    'text' => $node->text,
                    'children' => '[]'
                );
                
                if($node->depth > 0 && $child > 0) {
                    $children[$child]['leaf'] = 'false';
                    $currDepth = $node->depth;
                } else $currDepth =0;
               $tree[0]['children'] = $children; 
                
            } elseif ( $currDepth > 0) {
                 
                $babies[$child] = array('id' => $node->id,
                    'text' => $node->text,
                    
                );
                 $tree[0]['children'][1]['children'] = $babies;
                 $currDepth--;
             }else {
                $children[$child]['leaf'] = 'false';
            }
            }
         
            // $nextDepth++;
        }
        
         
             */
           
           if ($child < $tt) {
              
                $nextDepth = $trees[$child + 1]->depth;
               // continue;
            } else {
                $nextDepth = 0;
            }
          $str .= '{"id": ' . $node->id. ',"text":" ' . $node->text . ' ","leaf":';
          if($node->childNodes > 0) {             
               $str .= 'false,"children":[';
          } else {
               $str .= 'true}';
          if($nextDepth < $node->depth){
                 $str .= str_repeat(']}',$node->depth-$nextDepth);
                }
                
                if($nextDepth){
                    $str .=',';
                }else{
                    $str .= ']';
                }
          }  
                
        }
         echo $str;    
       // \Zend\Debug::dump($str);
        exit;
    }

    function appendTreeChildAction() {
        $tableName = 'tree';
        $table = $this->locator->get('Dbtable');
        $table->setOptions(array('name' => $tableName));


        $lastChild = 0;
        /*
          SET @lastChild=(SELECT rt FROM tree WHERE id=#id#);
          UPDATE tree SET lft=lft+2 WHERE lft>=@lastChild;
          UPDATE tree SET rt=rt+2 WHERE rt>=@lastChild;
          SET NOCOUNT ON INSERT INTO tree (text,lft,rt) VALUES ('#FORM.text#',@lastChild,@lastChild+1) SELECT id=@@identity SET NOCOUNT OFF

         */
        echo "string" === gettype($nodeID) ? '{"success":false,"error":"' . $nodeID . '"}' : '{"success":true,"id":' . $nodeID . '}';
    }

    function insertTreeChildAction() {
        $nodeID = $otree->insertChild();
        echo "string" === gettype($nodeID) ? '{"success":false,"error":"' . $nodeID . '"}' : '{"success":true,"id":' . $nodeID . '}';
    }

    public function removeTreeNodeAction() {
        $nodeID = $otree->removeNode();
        echo "string" === gettype($nodeID) ? '{"success":false,"error":"' . $nodeID . '"}' : '{"success":true}';
    }

    public function renameTreeNodeAction() {
        $nodeID = $otree->renameNode();
        echo "string" === gettype($nodeID) ? '{"success":false,"error":"' . $nodeID . '"}' : '{"success":true}';
    }

    public function moveTreeNodeAction() {
        $error = $otree->moveNode();
        echo "string" === gettype($error) ? '{"success":false,"error":"' . $nodeID . '"}' : '{"success":true}';
    }

    protected function _create($postdata, $tableName) {
        //if all went bad
        $response = '{
                        "success": false,  "type" : "ext-mb-error",                      
                        "message" : " ' . $this->lang->translate('failedToCreateRecords') . ' "
                     }';

        $table = $this->locator->get('Dbtable');
        $table->setOptions(array('name' => $tableName));
        $i = 0;
        $j = 0;

        //Delete records from the database
        foreach ($postdata as $data) {
            try {
                // $where = $table->getAdapter()->quoteInto('id = ?', $data->id);
                if ($table->insert($data))
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
                             "message": ' . json_encode($i . ' ' . $this->lang->translate('recordsCreatedSuccessfully')) . ' 
                            }';
        } elseif ($j > 0) {
            $response = '{
                            "success": true,  "type" : "ext-mb-info",                             
                            "message": ' . json_encode($i . ' ' . $this->lang->translate('recordsCreatedSuccessfully') . '<br /> ' .
                            $j . ' ' . $this->lang->translate('recordsFailed')) . ' 
                        }';
        }

        return $response;
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

    protected function _delete($postdata, $tableName) {
        //msg if all went bad
        $response = '{
                        "success": false,   "type" : "ext-mb-error",                      
                        "message": " ' . $this->lang->translate('failedToDeleteRecords') . ' "
                     }';
        $request = $this->getRequest();
        $input = file_get_contents("php://input");
        parse_str($input, $puts);
        die(var_dump($puts));
        
        if ($request->isPost()) {
            $postdata = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
            $table = $this->locator->get('Dbtable');
            $table->setOptions(array('name' => $tableName));
            $i = 0;
            $j = 0;

            //Delete records from the database
            foreach ($postdata as $data) {
                try {
                    $where = $table->getAdapter()->quoteInto('id = ?', $data->id);
                    if ($table->delete($where))
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
                             "message": ' . json_encode($i . ' ' . $this->lang->translate('recordsRemovedSuccessfully')) . ' 
                            }';
            } elseif ($j > 0) {
                $response = '{
                            "success": true, "type" : "ext-mb-info",                              
                            "message": ' . json_encode($i . ' ' . $this->lang->translate('recordsRemovedSuccessfully') . '<br /> ' .
                                $j . ' ' . $this->lang->translate('recordsFailed')) . ' 
                        }';
            }
        }
        return $response;
    }

   protected function _reader($sql) {
        $response = '{
                        "success": false,
                        "total": 0,
                        "data": []
                     }';       
       if(empty($sql)) return $response;
       
         $adapter = $this->locator->get('Db');  
         QuickSQL::processQuery($sql, $adapter);
         $total = QuickSQL::getCount();
        if ($total > 0) {
            $response = '{
                            "success": true,
                            "total": ' . $total . ',
                            "articles":  ' . json_encode(QuickSQL::getResults()) . '  
                        }';
        }

        return $response;
    }

}

