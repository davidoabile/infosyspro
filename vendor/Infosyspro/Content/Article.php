<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Infosyspro\Content;

use Application\Model\TbArticle;


class Article implements \Infosyspro\RestInterfaceClasses
{
    protected $lib = null;
    protected $adapter = null;
    
    public function __construct(\Infosyspro\InfosysproLib $infosyspro ) 
    {
        $this->lib = $infosyspro ;
        $this->adapter = new TbArticle($infosyspro->getAdapter());
    }


    /**
     * RESTFull POST
     * @param array $locator
     * @param array $data
     * @return boolean 
     */
    public function create ( Array $data )
    {
        $method = strtolower ( array_pop ( explode ( '_' , $data['object'] ) ) ) ;
	    unset ( $data['object'] ) ;
	    if ( method_exists ( $this , $method ) ) {
		return $this->$method ( $data ) ;
	    }
	
    }

    /**
     * RESTful delete
     * @param array $locator
     * @param init $id
     * @return boolean 
     */
    public function delete ( $id )
    {
	$this->mysql->delete($id);
    }

    /**
     * RESTFul GET
     * @param array $locator
     * @param int $id
     * @param array $data
     * @return bool 
     */
    public function get ( $id , Array $data )
    {
        return $this->mysql->getRow($id);
      
    }
    
     public function getList (Array $data )
    {
	
        //check which method has been called
        if(!empty( $data['method'])) {
            $method = $data['method'];
       
        if(method_exists($this, $method)) {
            return $this->$method( $data);
        }
	
        }
       return false;
      
    }
    
    protected function listArticles($data) 
    {
        $data = $this->adapter->fetchAll();    
           
        return array('success' => true,
                    'total'   =>  count($data),
                     'articles' =>  $data  
                     ); 
    }
    /**
     * RESTFul PUT
     * @param array $locator
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    public function update ( $id , Array $data )
    {
	return $this->mysql->updateRow ( $data ) ;
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

    

    public function articleReader($query, $id = false) {
        $where = '';
        $limit = ((int) $query['limit'] > 0 ) ? $query['limit'] : 20;
        $start = ((int) $query['start'] > -1 ) ? $query['start'] : 0;
        $order = ' ORDER BY ' . $query['sort'] . ' ' . $query['dir'];

        if ($id) {
            $where = ' AND id =' . (int) $id;
        }

        $sql = 'SELECT id, title, alias, content_type, published, created, ordering, hits 
                FROM TbContent WHERE published = 1 ' . $where . $order .
                ' LIMIT ' . $start . ',' . $limit;

        return $this->_reader($sql);
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
}
