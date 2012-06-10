<?php
return array(
		'TbContent' => array(
						'default' => array ( 'acl' => 'guest',
											 'sql' => 'SELECT id, title, alias, content_type, published, created, ordering, hits FROM TbContent WHERE published = 1 ',
											),
				        'custom' => array ( 'acl' => 'admin',
				        					 'sql' => 'SELECT id, title, alias, content_type, published, created, ordering, hits FROM TbContent WHERE published = 1 AND id=[id]',
				        		          ),
				),				
);