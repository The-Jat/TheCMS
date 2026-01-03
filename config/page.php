<?php

return [
	'name' 				=> 'Page',
	'slug' 				=> 'page',
	'route_prefix' 		=> 'pages',
	'ScreenOption' 		=> array(
		'PageAttributes'	=> array('visibility' => false),
		'FeaturedImage'		=> array('visibility' => true),
		'Excerpt'			=> array('visibility' => true),
		'CustomFields'		=> array('visibility' => true),
		'Discussion'		=> array('visibility' => false),
		'Slug'				=> array('visibility' => false),
		'Author'			=> array('visibility' => true),
		'PageType'			=> array('visibility' => false),
		'Seo'				=> array('visibility' => true),
	),
	'status' => array(
					'1' => 'Published', 
					'2' => 'Draft', 
					'3' => 'Trash', 
					'4' => 'Private', 
					'5' => 'Pending'
				),
];
