<?php

return [
	'name' => 'W3CPT',
	'slug' => 'w3-cpt',
	'post_type' => 'cpt',
	'post_type_taxo' => 'cpt-taxo',

	'ScreenOption'  => array(
		'cpt_options' => array(
			'Title'         => array('visibility' => true, 'display_title' => 'title_default', 'default' => true),
			'Editor'        => array('visibility' => true, 'display_title' => 'editor_default', 'default' => true),
			'Excerpt'       => array('visibility' => true, 'display_title' => 'excerpt_default', 'default' => true),
			'Slug'          => array('visibility' => false, 'display_title' => 'slug', 'default' => false),
			'CustomFields'  => array('visibility' => true, 'display_title' => 'custom_fields', 'default' => false),
			'Discussion'    => array('visibility' => false, 'display_title' => 'comments', 'default' => false),
			'FeaturedImage' => array('visibility' => true, 'display_title' => 'featured_image', 'default' => false),
			'Author'        => array('visibility' => true, 'display_title' => 'author', 'default' => false),
			'PageAttributes' => array('visibility' => true, 'display_title' => 'page_attributes', 'default' => false),
			'Seo'			=> array('visibility' => true, 'display_title' => 'seo', 'default' => false),
			'Video'			=> array('visibility' => false, 'display_title' => 'video', 'default' => false),
		),
		'taxonomy_options'	=> array(
			'Categories'	=> array('visibility' => true, 'display_title' => 'categories', 'default' => false),
			'Tags'			=> array('visibility' => true, 'display_title' => 'tags', 'default' => false),
		)
		
	),
];
