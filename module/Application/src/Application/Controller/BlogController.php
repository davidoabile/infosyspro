<?php

 namespace Application\Controller;

 class BlogController extends ActionController
 {

     public function init()
     {
         $this->table->setOptions(array('name' => 'TbContent'));
        $this->company->setHeadLink('appendStylesheet', array('/media/site/css/blog.css'));
     }

     public function indexAction()
     {
         $this->layoutParams['data'] = $this->_listBlogs();
         return $this->layoutParams;
     }

    
     protected function _renderContent($contentid)
     {
         $table = $this->locator->get('Dbtable');       
         $table->setOptions(array('name' => 'TbContent'));

         $id = str_replace('-', '', $contentid);

         if ($this->layoutParams['config']->siteOffline) {
             return $this->_getOfflineMsg();
         }

         $lang = $this->layoutParams['lang'];

        $content = $this->table->fetchRow(array('field' => 'action', 'value' => $id));
     
         if (!isset($content['id'])) {

             $data = '  <div class="article-rel-wrapper">
                     <h2 class="contentheading"> ' . $lang->translate('noBlogFound') . '</h2>
                     <p class="buttonheading"></p>
                      </div>';
             $this->layoutParams['data'] = $data . $lang->translate('noBlogFoundinfo') . '<p>' . $this->_listBlogs() .  '</p>';
             return $this->layoutParams;
         }

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

         if ($params->show_publish_date == 1) {
             $attribs .= '<span class="createdate"> ' . $lang->translate('publishedOn') . ' ' . $content['publish_up'] . '  </span>';
         }

         if ($params->show_hits == 1) {
             $attribs .= '<span class="modifydate"> ' . $content->hits . ' ' . $lang->translate('views') . '</span>';
         }

         if ($params->show_intro == 1) {
             $text = $content['introtext'];
         } else {
             $text = $content['fulltext'];
         }

         if ($params->alternative_readmore == 1) {
             $data .= '<span class="createdate"> ' . $lang->translate('readMore') . '</span>';
         }

         if($content->images) {
             $data .= ' <header ><div class="wp-caption alignnone" style="width: 97%">
                        <img  width="100%" src="' . $content['images'] . '" alt="Boat">
                        </div> <span class="article_separator">&nbsp;</span><div class="entry-meta">
                       <span class="sep">Posted on </span><a rel="bookmark" title="10:40 pm" href="http://wp-themes.com/?p=1"><time 
                       pubdate="" datetime="2008-06-04T22:40:06+00:00" class="entry-date">June 4, 2008</time></a><span class="by-author"> <span class="sep"> by </span>
                       <span class="author vcard"><a rel="author" title="View all posts by Theme Admin" href="http://wp-themes.com/?author=1" class="url fn n">Theme Admin</a></span></span>		</div><!-- .entry-meta -->
                    </header>';

         }
         $data .= '<div class="article-info-surround"><div class="article-info-surround2"><p class="articleinfo">  ' . $attribs . '</p></div></div>';

         /* Do some update */
         $hits = (int) $content->hits + 1;
       
         $table->updateRow(array('hits' => $hits, 'id' => $content['id']));

       // $this->layoutParams['comments'] = $this->_getComments($content['id'], $params );

        $this->layoutParams['data'] = $data . $text;

         return $this->layoutParams;
     }

     protected function _displayBlogForm()
     {
         
     }

     protected function _getOfflineMsg()
     {

         return array('template' => $this->layoutParams['template'],
             'setUp' => null,
             'lang' => $this->lang,
             'data' => $this->layoutParams['config']->offlineMessage,
         );
     }

     protected function _listBlogs()
     {
         $list = '  <div class="article-rel-wrapper">
                     <h2 class="contentheading"> ' . $this->layoutParams['lang']->translate('listOfActiveBlogs') . '</h2>
                     <p class="buttonheading"></p>
                      </div>';
         
         $table = $this->table;       
         
         $where = array('where' => array(
                                        'published' => 1,
                                        'content_type' => 'blog',
                                        'language' => $this->layoutParams['currentlang'],
                                    )
        );

        $content = $table->fetchAll($where);
         
         foreach($content as $k => $title) {
             $list .= '<h3>' . $title['title'] . '</h3>' . $title['introtext'] 
                     . '<div style="text-align:right; padding-right: 15px"><a href="/blog/' 
                     . $title['alias'] . '" title="' . $this->layoutParams['lang']->translate('readMore') ;
             $list .= '" >' . $this->layoutParams['lang']->translate('readMore') . '</a></div>';
             $list .= '<hr class="system-pagebreak" style="color: gray; border: 1px dashed gray;" alt="Media Manager" title="Media Manager">'; 
                      
         }
         
         if($list == '') {
             $list = $this->layoutParams['lang']->translate('thereAreNoBlogsRecorded');
         }
         return $list;
     }

     protected function _getComments($blogid,$blogParams)
     {
         $table = $this->locator->get('Dbtable');
        // $table->setOptions(array('name' => 'TbBlogReplies'));
        // $table->getAdapter()->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
          $data = $table->select()
                 ->where('blogid = ?', $blogid)
                 ->where('commentApproved = ?', 0)
                 ->order('commentTime ASC');
            //echo $data->__toString();exit;
         $content = $this->table->fetchAll($data);
        
         if (!isset($content[0])) {
             return  '<div class="article-rel-wrapper">
                     <h2 class="contentheading"> ' . $this->layoutParams['lang']->translate('noBlogComments') . '</h2>
                     <p class="buttonheading"></p>
                      </div>';
         }
          $data = '  <div class="article-rel-wrapper">
                     <h2 class="contentheading"> ' . $content[0]->postSubject . '</h2>
                     <p class="buttonheading"></p>
                      </div>';

          $data .= '<ol class="commentlist">';

         foreach($content as $k =>$comments) {

         $link = '#';
         if(isset($blogParams->enablePosterSite) && $blogParams->enablePosterSite) {
             $link = $comments->posterWebsite;
         }

         $gravatar = '/media/site/images/nogravatar.gif';
         if(isset($blogParams->enableGravatar) && $blogParams->enableGravatar) {
             $gravatar = '/media/site/images/gravatar/ ' . $comments->posterid . '.gif';
         }
         $data .= ' <li id="li-comment-1" class="comment even thread-even depth-1">
                        <article class="comment" id="comment-1">
                            <footer class="comment-meta">
                                <div class="comment-author vcard">
                                    <img width="68" height="68" class="avatar avatar-68 photo avatar-default" src="' . $gravatar . '" alt="">
                                    <span class="fn"><a class="url" rel="external nofollow" href="' . $link . '">' . $comments->posterName . '</a></span> on
                                    <a href="#"><time datetime="' . $comments->commentTime . '" pubdate="">' .  $comments->commentTime . '</time></a>
                                    <span class="says">' .  $this->layoutParams['lang']->translate('said') . '</span>
                                </div>
                            </footer>

                            <div class="comment-content"><p>' . $comments->comment . '</p>
                            </div>
                            <div class="reply"></div>
                        </article>

                        </li>';
         }

         return $data . ' </ol>';
     }
 }

 