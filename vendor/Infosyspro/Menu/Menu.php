<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Menu implements \Infosyspro\RestInterfaceClasses
{
     
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
            $str .= '{"id": ' . $node->id . ',"text":" ' . $node->text . ' ","leaf":';
            if ($node->childNodes > 0) {
                $str .= 'false,"children":[';
            } else {
                $str .= 'true}';
                if ($nextDepth < $node->depth) {
                    $str .= str_repeat(']}', $node->depth - $nextDepth);
                }

                if ($nextDepth) {
                    $str .=',';
                } else {
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

}
