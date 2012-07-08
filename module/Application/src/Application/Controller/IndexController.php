<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends ActionController
{

    public function init()
    {
        $this->table = $this->company->getModel('Application\\Model\\TbContent');
	//$this->layout()->company = $this->company;
    }

    public function indexAction()
    {
        //$t = new InstallCompany('infosys', $this->locator);

        if ($this->layoutParams['config']->siteOffline) {
            return $this->_getOfflineMsg();
        }
        //
      //  $this->layoutParams['data'] = $this->_getContent(1);      
        $this->layout()->template =  $this->layoutParams['template'];  
	$this->layout()->company = $this->company;
        return new ViewModel(array( 'data' => $this->_getContent(1)));
    }

    public function registerAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $userManager = $this->locator->get('userManager');
            $formData = $request->post()->toArray();
            $userManager->register($formData);
        }

        // Redirect to list of albums
        return $this->redirect()->toRoute('default', array(
                    'controller' => 'index',
                    'action' => 'index',
                ));
    }

    public function testAction() {
        
    }
    protected function _getContent($contentid)
    {
        $lang = $this->layoutParams['lang'];
        
        $content = $this->table->getRow($contentid);

        $params = json_decode($content['attribs']);
        $data = '';
        $this->company->setPageTitle($content['title']);
        if ($params->show_title == 1) {
            $data .= '  <div class="article-rel-wrapper">
                     <h2 class="contentheading"> ' . $content['title'] . '</h2>
                     <p class="buttonheading"></p>
                      </div>';
        } else {
            $data .= '<p>&nbsp;</p>';
        }
        $attribs = '';
        if ($params->show_author == 1) {
            $attribs .= '<span class="createdby"> ' . $lang->translate('writtenBy') . ' ' . $content['created_by'] . ' </span>';
        }

        if ($params->show_create_date == 1) {
            $attribs .= '<span class="createdate"> ' . $lang->translate('createdOn') . ' ' . $content['created'] . '</span>';
        }

        if ($params->show_modify_date == 1) {
            $attribs .= '<span class="modifydate"> ' . $lang->translate('lastModifiedOn') . ' ' . $content['modified'] . ' </span>';
        }

        //  if($params->show_publish_date == 1) {
        //    $attribs .= '<span class="createdate"> ' . $lang->translate('publishedOn') . ' ' .  $content[0]->publish_up . '  </span>';
        //}

        if ($params->show_hits == 1) {
            $attribs .= '<span class="modifydate"> ' . $content['hits'] . ' ' . $lang->translate('views') . '</span>';
        }

        if ($params->show_intro == 1) {
            $text = $content['introtext'];
        } else {
            $text = $content['introtext'];
        }
        /*
          if($params->alternative_readmore == 1) {
          $data .= '<span class="modifydate"> Last Updated on Saturday, 09 August 2008 07:49 </span>
          <span class="createdby"> Written by Administrator </span>
          <span class="createdate"> Saturday, 09 August 2008 07:49 </span>';
          }
         * 
         */

        $data .= '<div class="article-info-surround"><div class="article-info-surround2"><p class="articleinfo">  ' . $attribs . '</p></div></div>';

        /* Do some update */
        $hits = (int) $content['hits'] + 1;
        // $where = $this->table->getAdapter()->quoteInto('id = ?', $content[0]->id);
        $this->table->updateRow(array('hits' => $hits, 'id' => $content['id']));

        return $data . $content['fulltext'];
    }

    protected function _getOfflineMsg()
    {

        return array('template' => $this->layoutParams['template'],
            'setUp' => null,
            'lang' => $this->lang,
            'data' => $this->layoutParams['config']->offlineMessage,
        );
    }

}
